<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Dokter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Jadwal;
use App\Models\Poli;
use App\Models\User;

class AppointmentController extends Controller
{
    public function index(): View
    {
        $pasien = Auth::user()->pasien;
        $appointments = Appointment::where('pasien_id', $pasien->id)
            ->with(['dokter.user', 'poli', 'jadwal'])
            ->latest()
            ->paginate(15);

        return view('pasien.appointment.index', compact('appointments'));
    }

    public function cancel(Appointment $appointment): RedirectResponse
    {
        $pasien = Auth::user()->pasien;

        // Validasi appointment milik pasien ini
        if ($appointment->pasien_id !== $pasien->id) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya bisa dibatalkan jika statusnya Menunggu atau Diproses
        if (!in_array($appointment->status, ['Menunggu', 'Diproses'])) {
            return redirect()->back()->withErrors(['error' => 'Antrian tidak dapat dibatalkan.']);
        }

        $appointment->update([
            'status' => 'Dibatalkan',
            'catatan_admin' => 'Dibatalkan oleh pasien pada ' . now()->format('d/m/Y H:i'),
        ]);

        return redirect()->route('pasien.appointment.index')->with('success', 'Antrian berhasil dibatalkan.');
    }

    public function create(Request $request): View
    {
        $poliList = Poli::where('status', 'aktif')->get();
        $dokterList = collect();
        $jadwalOptions = collect();

        $poliId = $request->query('poli_id');
        $dokterId = $request->query('dokter_id');
        $tanggal = $request->query('tanggal_usulan');
        $selectedJadwalId = $request->query('jadwal_id');
        $selectedJadwal = null;
        $queueAppointments = collect();
        $currentQueueCount = 0;

        // Jika poli dipilih, tampilkan daftar dokter di poli tersebut
        if ($poliId) {
            $dokterList = Dokter::where('poli_id', $poliId)
                ->with('user')
                ->get();
        }

        // Jika dokter dan tanggal dipilih, tampilkan jadwal
        if ($dokterId && $tanggal) {
            $jadwalOptions = Jadwal::where('dokter_id', $dokterId)
                ->whereDate('tanggal', $tanggal)
                ->where('status', 'tersedia')
                ->with('dokter.user', 'dokter.poli')
                ->orderBy('jam_mulai')
                ->get();
        }

        if ($selectedJadwalId) {
            $selectedJadwal = Jadwal::find($selectedJadwalId);
            if ($selectedJadwal) {
                $queueAppointments = Appointment::where('jadwal_id', $selectedJadwal->id)
                    ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
                    ->with(['pasien.user'])
                    ->orderBy('nomor_antrian')
                    ->get();
                $currentQueueCount = $queueAppointments->count();
            }
        }

        return view('pasien.appointment.create', compact(
            'poliList',
            'dokterList',
            'jadwalOptions',
            'poliId',
            'dokterId',
            'tanggal',
            'selectedJadwalId',
            'selectedJadwal',
            'queueAppointments',
            'currentQueueCount'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $pasien = Auth::user()->pasien;
        $data = $request->validate([
            'poli_id' => ['required', 'exists:polis,id'],
            'dokter_id' => ['required', 'exists:dokter,id'],
            'tanggal_usulan' => ['required', 'date', 'after_or_equal:today'],
            'jadwal_id' => ['required', 'exists:jadwal,id'],
            'keluhan' => ['nullable', 'string'],
        ]);

        $jadwal = Jadwal::with('dokter')->findOrFail($data['jadwal_id']);

        // Validasi jadwal masih tersedia
        if ($jadwal->status !== 'tersedia') {
            return redirect()->back()->withErrors(['jadwal_id' => 'Jadwal tidak tersedia.'])->withInput();
        }

        // Validasi pasien belum punya antrian aktif di jadwal yang sama
        $existingAppointment = Appointment::where('pasien_id', $pasien->id)
            ->where('jadwal_id', $jadwal->id)
            ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
            ->first();

        if ($existingAppointment) {
            return redirect()->back()->withErrors(['jadwal_id' => 'Anda sudah memiliki antrian aktif di jadwal ini.'])->withInput();
        }

        // Gunakan database transaction dan locking untuk mencegah race condition
        \DB::beginTransaction();
        try {
            // Lock row untuk mencegah race condition
            $currentQueue = Appointment::where('jadwal_id', $jadwal->id)
                ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
                ->lockForUpdate()
                ->count();

            // Batas maksimal antrian per jadwal (bisa disesuaikan)
            $maxQueue = 30;
            if ($currentQueue >= $maxQueue) {
                \DB::rollBack();
                return redirect()->back()->withErrors(['jadwal_id' => 'Antrian sudah penuh untuk jadwal ini.'])->withInput();
            }

            $data['pasien_id'] = $pasien->id;
            $data['dokter_id'] = $jadwal->dokter_id;
            $data['jam_usulan'] = $jadwal->jam_mulai;
            $data['status'] = 'Menunggu';
            $data['nomor_antrian'] = $currentQueue + 1;

            $appointment = Appointment::create($data);

            // Jangan ubah status jadwal, biarkan tetap 'tersedia' untuk pasien lain
            // Hanya update keterangan jika diperlukan
            if (!$jadwal->keterangan) {
                $jadwal->update([
                    'keterangan' => 'Jadwal antrian online tersedia',
                ]);
            }

            \DB::commit();

            // Kirim notifikasi ke pasien
            $pasien->user->notify(new \App\Notifications\AppointmentCreated($appointment));

            // Kirim notifikasi ke dokter
            if ($jadwal->dokter && $jadwal->dokter->user) {
                $jadwal->dokter->user->notify(new \App\Notifications\NewAppointmentForDokter($appointment));
            }

            // Kirim notifikasi ke semua Admin
            $admins = User::role('Admin')->get();
            if ($admins->isNotEmpty()) {
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\NewAppointmentForAdmin($appointment));
                }
            }

            return redirect()->route('pasien.appointment.index')->with('success', 'Antrian berhasil diambil. Nomor antrian Anda: ' . $appointment->nomor_antrian);
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }
}
