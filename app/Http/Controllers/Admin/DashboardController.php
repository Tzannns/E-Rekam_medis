<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $totalDokter = Dokter::count();
        $totalPasien = Pasien::count();
        $totalRekamMedis = RekamMedis::count();

        $recentRekamMedis = RekamMedis::with(['pasien.user', 'dokter.user'])
            ->latest()
            ->limit(10)
            ->get();

        // Antrian terbaru
        $recentAntrian = \App\Models\Appointment::with(['pasien.user', 'dokter.user', 'poli'])
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDokter',
            'totalPasien',
            'totalRekamMedis',
            'recentRekamMedis',
            'recentAntrian'
        ));
    }
}
