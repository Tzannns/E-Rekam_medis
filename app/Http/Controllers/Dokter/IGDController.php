<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateIGDRequest;
use App\Models\Dokter;
use App\Models\IGD;
use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IGDController extends Controller
{
    public function index(Request $request): View
    {
        $dokter = Auth::user()->dokter;
        $query = IGD::where('dokter_id', $dokter->id)
            ->with('pasien.user', 'dokter.user');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pasien.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('keluhan_utama', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        // Filter by pasien
        if ($request->has('pasien_id') && $request->pasien_id) {
            $query->where('pasien_id', $request->pasien_id);
        }

        // Filter by triase level
        if ($request->has('triase_level') && $request->triase_level) {
            $query->where('triase_level', $request->triase_level);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_masuk', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_masuk', '<=', $request->tanggal_sampai.' 23:59:59');
        }

        $igds = $query->latest('tanggal_masuk')->paginate(15);
        $pasienList = Pasien::with('user')->get();

        return view('dokter.igd.index', compact('igds', 'pasienList'));
    }

    public function show(IGD $igd): View
    {
        $igd->load('pasien.user', 'dokter.user');

        return view('dokter.igd.show', compact('igd'));
    }

    public function edit(IGD $igd): View
    {
        $igd->load('pasien.user', 'dokter.user');
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();

        return view('dokter.igd.edit', compact('igd', 'pasiens', 'dokters'));
    }

    public function update(UpdateIGDRequest $request, IGD $igd): RedirectResponse
    {
        $igd->update($request->validated());

        return redirect()
            ->route('dokter.igd.show', $igd)
            ->with('success', 'Data IGD berhasil diperbarui');
    }
}
