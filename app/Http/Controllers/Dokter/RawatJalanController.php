<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRawatJalanRequest;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\RawatJalan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RawatJalanController extends Controller
{
    public function index(Request $request): View
    {
        $dokter = Auth::user()->dokter;
        $query = RawatJalan::where('dokter_id', $dokter->id)
            ->with('pasien.user', 'dokter.user', 'poli');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pasien.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('poli', function ($q) use ($search) {
                        $q->where('nama_poli', 'like', "%{$search}%");
                    })
                    ->orWhere('keluhan', 'like', "%{$search}%")
                    ->orWhere('diagnosa', 'like', "%{$search}%");
            });
        }

        // Filter by pasien
        if ($request->has('pasien_id') && $request->pasien_id) {
            $query->where('pasien_id', $request->pasien_id);
        }

        // Filter by poli
        if ($request->has('poli_id') && $request->poli_id) {
            $query->where('poli_id', $request->poli_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_kunjungan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_kunjungan', '<=', $request->tanggal_sampai.' 23:59:59');
        }

        $rawatJalans = $query->latest('tanggal_kunjungan')->paginate(15);
        $pasienList = Pasien::with('user')->get();
        $poliList = Poli::all();

        return view('dokter.rawat-jalan.index', compact('rawatJalans', 'pasienList', 'poliList'));
    }

    public function show(RawatJalan $rawatJalan): View
    {
        $rawatJalan->load('pasien.user', 'dokter.user', 'poli');

        return view('dokter.rawat-jalan.show', compact('rawatJalan'));
    }

    public function edit(RawatJalan $rawatJalan): View
    {
        $rawatJalan->load('pasien.user', 'dokter.user', 'poli');
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();
        $polis = Poli::all();

        return view('dokter.rawat-jalan.edit', compact('rawatJalan', 'pasiens', 'dokters', 'polis'));
    }

    public function update(UpdateRawatJalanRequest $request, RawatJalan $rawatJalan): RedirectResponse
    {
        $rawatJalan->update($request->validated());

        return redirect()
            ->route('dokter.rawat-jalan.show', $rawatJalan)
            ->with('success', 'Data Rawat Jalan berhasil diperbarui');
    }
}
