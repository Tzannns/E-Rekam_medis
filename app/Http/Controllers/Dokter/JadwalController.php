<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(): View
    {
        $dokter = Auth::user()->dokter;

        // Menampilkan jadwal pemeriksaan berdasarkan appointment yang disetujui
        $jadwalPemeriksaan = Appointment::where('dokter_id', $dokter->id)
            ->whereIn('status', ['disetujui', 'selesai'])
            ->with(['pasien.user', 'poli', 'jadwal'])
            ->orderBy('tanggal_usulan', 'desc')
            ->orderBy('jam_usulan', 'desc')
            ->paginate(15);

        return view('dokter.jadwal.index', compact('jadwalPemeriksaan'));
    }
}
