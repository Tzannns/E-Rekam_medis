<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Appointment::with(['pasien.user', 'dokter.user', 'poli']);

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pasien.user', function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%");
                })->orWhereHas('dokter.user', function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%");
                })->orWhere('keluhan', 'like', "%{$search}%");
            });
        }

        $appointments = $query->latest()->paginate(15);
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view('admin.appointment.index', compact('appointments', 'pasienList', 'dokterList'));
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['pasien.user', 'dokter.user', 'poli']);
        $dokterList = Dokter::with('user')->get();

        return view('admin.appointment.show', compact('appointment', 'dokterList'));
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $data = $request->validate([
            'dokter_id' => ['nullable', 'exists:dokter,id'],
            'status' => ['required', 'in:Disetujui,Diproses,Dibatalkan,Menunggu'],
            'catatan_admin' => ['nullable', 'string'],
            'tanggal' => ['nullable', 'date'],
            'jam_mulai' => ['nullable', 'string'],
            'jam_selesai' => ['nullable', 'string'],
        ]);

        // Validasi dokter_id harus ada jika status Disetujui
        if ($data['status'] === 'Disetujui' && empty($data['dokter_id']) && empty($appointment->dokter_id)) {
            return redirect()->back()->withErrors(['dokter_id' => 'Dokter harus dipilih untuk menyetujui appointment.'])->withInput();
        }

        $oldStatus = $appointment->status;

        $appointment->update([
            'dokter_id' => $data['dokter_id'] ?? $appointment->dokter_id,
            'status' => $data['status'],
            'catatan_admin' => $data['catatan_admin'] ?? null,
        ]);

        // Kirim notifikasi jika status berubah
        if ($oldStatus !== $data['status']) {
            $appointment->pasien->user->notify(
                new \App\Notifications\AppointmentStatusUpdated($appointment, $oldStatus, $data['status'])
            );
        }

        if (in_array($data['status'], ['Disetujui', 'Diproses'])) {
            if ($appointment->jadwal_id) {
                $jadwal = Jadwal::find($appointment->jadwal_id);
                if ($jadwal) {
                    // Jangan ubah status jadwal jika masih ada antrian lain yang aktif
                    $activeQueueCount = Appointment::where('jadwal_id', $jadwal->id)
                        ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
                        ->count();

                    if ($activeQueueCount === 0) {
                        $jadwal->update([
                            'status' => 'tersedia',
                        ]);
                    }
                }
            } elseif ($data['tanggal'] && $data['jam_mulai']) {
                $jadwal = Jadwal::create([
                    'dokter_id' => $appointment->dokter_id,
                    'poli_id' => $appointment->poli_id,
                    'pasien_id' => $appointment->pasien_id,
                    'tanggal' => $data['tanggal'],
                    'jam_mulai' => $data['jam_mulai'],
                    'jam_selesai' => $data['jam_selesai'] ?? null,
                    'status' => 'terisi',
                    'keterangan' => 'Periksa dari permohonan #'.$appointment->id,
                ]);
                $appointment->update(['jadwal_id' => $jadwal->id]);
            }
        }

        return redirect()->route('admin.appointment.show', $appointment)->with('success', 'Permohonan diperbarui');
    }
}
