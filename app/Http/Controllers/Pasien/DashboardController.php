<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Jadwal;
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

        $pendingAppointment = Appointment::where('pasien_id', $pasien->id)
            ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
            ->latest()
            ->first();

        $queueTotal = null;
        if ($pendingAppointment && $pendingAppointment->jadwal_id) {
            $queueTotal = Appointment::where('jadwal_id', $pendingAppointment->jadwal_id)
                ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
                ->count();
        }

        $upcomingJadwal = Jadwal::where('pasien_id', $pasien->id)
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->first();

        $activeQueueCount = Appointment::where('pasien_id', $pasien->id)
            ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
            ->count();

        $appointmentsTotal = Appointment::where('pasien_id', $pasien->id)->count();

        $availableToday = Jadwal::where('status', 'tersedia')
            ->where('tanggal', now()->toDateString())
            ->count();

        return view('pasien.dashboard', compact(
            'totalRekamMedis',
            'recentRekamMedis',
            'pendingAppointment',
            'queueTotal',
            'upcomingJadwal', 'activeQueueCount', 'appointmentsTotal', 'availableToday'
        ));
    }
}
