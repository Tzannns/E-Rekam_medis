<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $pasien = Auth::user()->pasien;
        if ($pasien === null) {
            return redirect()->route('pasien.profil.create')
                ->with('info', 'Lengkapi data profil pasien terlebih dahulu.');
        }

        $jadwal = Appointment::where('pasien_id', $pasien->id)
            ->whereIn('status', ['disetujui', 'selesai'])
            ->with(['dokter.user', 'poli'])
            ->orderBy('tanggal_usulan', 'desc')
            ->orderBy('jam_usulan', 'desc')
            ->paginate(15);

        return view('pasien.jadwal.index', compact('jadwal'));
    }
}
