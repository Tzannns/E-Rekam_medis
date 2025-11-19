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

    public function create(): View|RedirectResponse
    {
        $pasien = Auth::user()->pasien;
        if ($pasien === null) {
            return redirect()->route('pasien.profil.create')
                ->with('info', 'Lengkapi data profil pasien terlebih dahulu.');
        }

        return view('pasien.rekam-medis.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $pasien = Auth::user()->pasien;
        if ($pasien === null) {
            return redirect()->route('pasien.profil.create')
                ->with('info', 'Lengkapi data profil pasien terlebih dahulu.');
        }

        $validated = $request->validate([
            'tanggal_periksa' => 'required|date',
            'keluhan' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'alergi_obat' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        // Simpan data riwayat medis awal dari pasien
        // Nanti dokter yang akan melengkapi diagnosa dan tindakan
        RekamMedis::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => 1, // Temporary, akan diupdate oleh dokter
            'tanggal_periksa' => $validated['tanggal_periksa'],
            'keluhan' => $validated['keluhan'],
            'diagnosa' => 'Menunggu pemeriksaan dokter',
            'tindakan' => $validated['riwayat_penyakit'] ?? null,
            'resep_obat' => $validated['alergi_obat'] ?? null,
            'catatan' => $validated['catatan'],
        ]);

        return redirect()->route('pasien.rekam-medis.index')
            ->with('success', 'Riwayat medis berhasil disimpan.');
    }
}
