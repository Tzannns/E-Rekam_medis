<?php

namespace App\Http\Controllers\Petugas;

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

        return view('petugas.appointment.index', compact('appointments', 'pasienList', 'dokterList'));
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['pasien.user', 'dokter.user', 'poli']);
        $dokterList = Dokter::with('user')->get();

        return view('petugas.appointment.show', compact('appointment', 'dokterList'));
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $data = $request->validate([
            'dokter_id' => ['nullable', 'exists:dokter,id'],
            'status' => ['required', 'in:Disetujui,Diproses,Dibatalkan'],
            'catatan_admin' => ['nullable', 'string'],
            'tanggal' => ['nullable', 'date'],
            'jam_mulai' => ['nullable', 'string'],
            'jam_selesai' => ['nullable', 'string'],
        ]);

        $appointment->update([
            'dokter_id' => $data['dokter_id'] ?? null,
            'status' => $data['status'],
            'catatan_admin' => $data['catatan_admin'] ?? null,
        ]);

        if (in_array($data['status'], ['Disetujui', 'Diproses']) && $data['tanggal'] && $data['jam_mulai']) {
            $jadwal = Jadwal::create([
                'dokter_id' => $appointment->dokter_id,
                'pasien_id' => $appointment->pasien_id,
                'tanggal' => $data['tanggal'],
                'jam_mulai' => $data['jam_mulai'],
                'jam_selesai' => $data['jam_selesai'] ?? null,
                'status' => 'terisi',
                'keterangan' => 'Periksa dari permohonan #'.$appointment->id,
            ]);
            $appointment->update(['jadwal_id' => $jadwal->id]);
        }

        return redirect()->route('petugas.appointment.show', $appointment)->with('success', 'Permohonan diperbarui');
    }
}
