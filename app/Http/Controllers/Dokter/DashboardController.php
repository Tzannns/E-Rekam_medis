<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $dokter = Auth::user()->dokter;
        
        $totalRekamMedis = RekamMedis::where('dokter_id', $dokter->id)->count();
        $totalPasien = RekamMedis::where('dokter_id', $dokter->id)
            ->distinct('pasien_id')
            ->count('pasien_id');
        $jadwalHariIni = Appointment::where('dokter_id', $dokter->id)
            ->whereDate('tanggal_usulan', today())
            ->whereIn('status', ['disetujui', 'selesai'])
            ->count();
        
        $recentRekamMedis = RekamMedis::where('dokter_id', $dokter->id)
            ->with(['pasien.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dokter.dashboard', compact(
            'totalRekamMedis',
            'totalPasien',
            'jadwalHariIni',
            'recentRekamMedis'
        ));
    }
}
