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

class AppointmentController extends Controller
{
    public function index(): View
    {
        $pasien = Auth::user()->pasien;
        $appointments = Appointment::where('pasien_id', $pasien->id)
            ->with(['dokter.user', 'poli'])
            ->latest()
            ->paginate(15);

        return view('pasien.appointment.index', compact('appointments'));
    }

    public function create(Request $request): View
    {
        $poliList = Poli::where('status', 'aktif')->get();
        $jadwalOptions = collect();

        $poliId = $request->query('poli_id');
        $tanggal = $request->query('tanggal_usulan');
        $selectedJadwalId = $request->query('jadwal_id');
        $selectedJadwal = null;
        $queueAppointments = collect();
        $currentQueueCount = 0;

        if ($poliId && $tanggal) {
            $jadwalOptions = Jadwal::where('poli_id', $poliId)
                ->where('tanggal', $tanggal)
                ->where('status', 'tersedia')
                ->with('dokter.user')
                ->orderBy('jam_mulai')
                ->get();
        }

        if ($selectedJadwalId) {
            $selectedJadwal = Jadwal::find($selectedJadwalId);
            if ($selectedJadwal) {
                $queueAppointments = Appointment::where('jadwal_id', $selectedJadwal->id)
                    ->with(['pasien.user'])
                    ->orderBy('nomor_antrian')
                    ->get();
                $currentQueueCount = $queueAppointments->count();
            }
        }

        return view('pasien.appointment.create', compact(
            'poliList',
            'jadwalOptions',
            'poliId',
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
            'tanggal_usulan' => ['required', 'date'],
            'jadwal_id' => ['required', 'exists:jadwal,id'],
            'keluhan' => ['nullable', 'string'],
        ]);

        $data['pasien_id'] = $pasien->id;
        $jadwal = Jadwal::with('dokter')->findOrFail($data['jadwal_id']);
        $data['dokter_id'] = $jadwal->dokter_id;
        $data['jam_usulan'] = $jadwal->jam_mulai;
        $data['status'] = 'Diproses';

        $currentQueue = Appointment::where('jadwal_id', $jadwal->id)->count();
        $data['nomor_antrian'] = $currentQueue + 1;

        $appointment = Appointment::create($data);

        $jadwal->update([
            'pasien_id' => $pasien->id,
            'status' => 'terisi',
            'keterangan' => 'Terisi melalui antrian online #'.$appointment->id,
        ]);

        return redirect()->route('pasien.appointment.index')->with('success', 'Antrian berhasil diambil.');
    }
}
