<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalRekamMedis = RekamMedis::count();
        $recentRekamMedis = RekamMedis::with(['pasien.user', 'dokter.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('petugas.dashboard', compact(
            'totalRekamMedis',
            'recentRekamMedis'
        ));
    }
}
