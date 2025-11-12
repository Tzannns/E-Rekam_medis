<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIGDRequest;
use App\Http\Requests\UpdateIGDRequest;
use App\Models\Dokter;
use App\Models\IGD;
use App\Models\Pasien;

class IGDController extends Controller
{
    public function index()
    {
        $igds = IGD::with(['pasien', 'dokter'])->latest('tanggal_masuk')->paginate(10);

        return view('admin.igd.index', compact('igds'));
    }

    public function create()
    {
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();

        return view('admin.igd.create', compact('pasiens', 'dokters'));
    }

    public function store(StoreIGDRequest $request)
    {
        $igd = IGD::create($request->validated());

        return redirect()->route('admin.igd.show', $igd)->with('success', 'Data IGD berhasil ditambahkan');
    }

    public function show(IGD $igd)
    {
        $igd->load(['pasien', 'dokter']);

        return view('admin.igd.show', compact('igd'));
    }

    public function edit(IGD $igd)
    {
        $igd->load(['pasien', 'dokter']);
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();

        return view('admin.igd.edit', compact('igd', 'pasiens', 'dokters'));
    }

    public function update(UpdateIGDRequest $request, IGD $igd)
    {
        $igd->update($request->validated());

        return redirect()->route('admin.igd.show', $igd)->with('success', 'Data IGD berhasil diperbarui');
    }

    public function destroy(IGD $igd)
    {
        $igd->delete();

        return redirect()->route('admin.igd.index')->with('success', 'Data IGD berhasil dihapus');
    }
}
