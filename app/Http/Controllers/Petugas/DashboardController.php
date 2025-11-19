<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalPasien = Pasien::count();
        $totalRekamMedis = RekamMedis::count();
        $totalAppointment = Appointment::count();
        $appointmentMenunggu = Appointment::where('status', 'menunggu')->count();

        $recentRekamMedis = RekamMedis::with(['pasien.user', 'dokter.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('petugas.dashboard', compact(
            'totalPasien',
            'totalRekamMedis',
            'totalAppointment',
            'appointmentMenunggu',
            'recentRekamMedis'
        ));
    }
}
