<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $dokter = Auth::user()->dokter;
        $totalRekamMedis = RekamMedis::where('dokter_id', $dokter->id)->count();
        $recentRekamMedis = RekamMedis::where('dokter_id', $dokter->id)
            ->with(['pasien.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dokter.dashboard', compact(
            'totalRekamMedis',
            'recentRekamMedis'
        ));
    }
}
