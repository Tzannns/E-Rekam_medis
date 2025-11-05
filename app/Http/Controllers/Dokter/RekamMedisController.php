<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dokter\StoreRekamMedisRequest;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RekamMedisController extends Controller
{
    public function index(Request $request): View
    {
        $dokter = Auth::user()->dokter;
        $query = RekamMedis::where('dokter_id', $dokter->id)
            ->with(['pasien.user']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pasien.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('diagnosa', 'like', "%{$search}%")
                ->orWhere('keluhan', 'like', "%{$search}%");
            });
        }

        // Filter by pasien
        if ($request->has('pasien_id') && $request->pasien_id) {
            $query->where('pasien_id', $request->pasien_id);
        }

        // Filter by tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_periksa', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_periksa', '<=', $request->tanggal_sampai);
        }

        $rekamMedis = $query->latest()->paginate(15);
        $pasienList = Pasien::with('user')->get();

        return view('dokter.rekam-medis.index', compact('rekamMedis', 'pasienList'));
    }

    public function create(): View
    {
        $pasienList = Pasien::with('user')->get();

        return view('dokter.rekam-medis.create', compact('pasienList'));
    }

    public function store(StoreRekamMedisRequest $request): RedirectResponse
    {
        $dokter = Auth::user()->dokter;

        RekamMedis::create([
            ...$request->validated(),
            'dokter_id' => $dokter->id,
        ]);

        return redirect()->route('dokter.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function show(RekamMedis $rekamMedi): View
    {
        $rekamMedi->load(['pasien.user', 'dokter.user']);

        return view('dokter.rekam-medis.show', compact('rekamMedi'));
    }
}
