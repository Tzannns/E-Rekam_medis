<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(): View
    {
        $dokter = Auth::user()->dokter;
        $jadwal = Jadwal::where('dokter_id', $dokter->id)
            ->with(['pasien.user'])
            ->latest()
            ->paginate(15);
        
        return view('dokter.jadwal.index', compact('jadwal'));
    }
}
