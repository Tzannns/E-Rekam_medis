<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RawatInap;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RawatInapController extends Controller
{
    public function index(): View
    {
        $dokter = Auth::user()->dokter;

        $rawatInap = RawatInap::where('dokter_id', $dokter->id)
            ->with(['pasien.user'])
            ->latest('tanggal_masuk')
            ->paginate(15);

        return view('dokter.rawat-inap.index', compact('rawatInap'));
    }

    public function show(RawatInap $rawatInap): View
    {
        $dokter = Auth::user()->dokter;

        // Pastikan rawat inap ini milik dokter yang login
        if ($rawatInap->dokter_id !== $dokter->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini');
        }

        $rawatInap->load(['pasien.user', 'dokter.user']);

        return view('dokter.rawat-inap.show', compact('rawatInap'));
    }
}
