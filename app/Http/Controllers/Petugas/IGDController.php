<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Admin\IGDController as AdminIGDController;
use App\Http\Requests\StoreIGDRequest;
use App\Http\Requests\UpdateIGDRequest;
use App\Models\Dokter;
use App\Models\IGD;
use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IGDController extends AdminIGDController
{
    public function index(): View
    {
        $igds = IGD::with('pasien.user', 'dokter.user')
            ->latest('tanggal_masuk')
            ->paginate(10);

        return view('petugas.igd.index', compact('igds'));
    }

    public function create(): View
    {
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();

        return view('petugas.igd.create', compact('pasiens', 'dokters'));
    }

    public function store(StoreIGDRequest $request): RedirectResponse
    {
        $igd = IGD::create($request->validated());

        return redirect()
            ->route('petugas.igd.show', $igd)
            ->with('success', 'Data IGD berhasil ditambahkan');
    }

    public function show(IGD $igd): View
    {
        $igd->load('pasien.user', 'dokter.user');

        return view('petugas.igd.show', compact('igd'));
    }

    public function edit(IGD $igd): View
    {
        $igd->load('pasien.user', 'dokter.user');
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();

        return view('petugas.igd.edit', compact('igd', 'pasiens', 'dokters'));
    }

    public function update(UpdateIGDRequest $request, IGD $igd): RedirectResponse
    {
        $igd->update($request->validated());

        return redirect()
            ->route('petugas.igd.show', $igd)
            ->with('success', 'Data IGD berhasil diperbarui');
    }

    public function destroy(IGD $igd): RedirectResponse
    {
        $igd->delete();

        return redirect()
            ->route('petugas.igd.index')
            ->with('success', 'Data IGD berhasil dihapus');
    }
}
