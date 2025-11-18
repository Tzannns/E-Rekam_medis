<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RekamMedisController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $pasien = Auth::user()->pasien;
        if ($pasien === null) {
            return redirect()->route('pasien.profil.create')
                ->with('info', 'Lengkapi data profil pasien terlebih dahulu.');
        }

        $query = RekamMedis::where('pasien_id', $pasien->id)
            ->with(['dokter.user']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('dokter.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('diagnosa', 'like', "%{$search}%")
                    ->orWhere('keluhan', 'like', "%{$search}%");
            });
        }

        // Filter by tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_periksa', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_periksa', '<=', $request->tanggal_sampai);
        }

        $rekamMedis = $query->latest()->paginate(15);

        return view('pasien.rekam-medis.index', compact('rekamMedis'));
    }

    public function show(RekamMedis $rekamMedi): View
    {
        $pasien = Auth::user()->pasien;

        if ($pasien === null) {
            abort(403);
        }

        // Ensure pasien can only view their own records
        if ($rekamMedi->pasien_id !== $pasien->id) {
            abort(403);
        }

        $rekamMedi->load(['dokter.user']);

        return view('pasien.rekam-medis.show', compact('rekamMedi'));
    }
}
