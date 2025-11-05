<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pasien = Auth::user()->pasien;
        if ($pasien === null) {
            // User belum memiliki profil pasien; tampilkan dashboard kosong dengan info
            $totalRekamMedis = 0;
            $recentRekamMedis = collect();

            return view('pasien.dashboard', compact(
                'totalRekamMedis',
                'recentRekamMedis'
            ));
        }

        $totalRekamMedis = RekamMedis::where('pasien_id', $pasien->id)->count();
        $recentRekamMedis = RekamMedis::where('pasien_id', $pasien->id)
            ->with(['dokter.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('pasien.dashboard', compact(
            'totalRekamMedis',
            'recentRekamMedis'
        ));
    }
}
