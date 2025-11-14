<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Admin\RawatJalanController as AdminRawatJalanController;
use App\Http\Requests\StoreRawatJalanRequest;
use App\Http\Requests\UpdateRawatJalanRequest;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\RawatJalan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RawatJalanController extends AdminRawatJalanController
{
    public function index(): View
    {
        $rawatJalans = RawatJalan::with('pasien.user', 'dokter.user', 'poli')
            ->latest('tanggal_kunjungan')
            ->paginate(10);

        return view('petugas.rawat-jalan.index', compact('rawatJalans'));
    }

    public function create(): View
    {
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();
        $polis = Poli::all();

        return view('petugas.rawat-jalan.create', compact('pasiens', 'dokters', 'polis'));
    }

    public function store(StoreRawatJalanRequest $request): RedirectResponse
    {
        $rawatJalan = RawatJalan::create($request->validated());

        return redirect()
            ->route('petugas.rawat-jalan.show', $rawatJalan)
            ->with('success', 'Data Rawat Jalan berhasil ditambahkan');
    }

    public function show(RawatJalan $rawatJalan): View
    {
        $rawatJalan->load('pasien.user', 'dokter.user', 'poli');

        return view('petugas.rawat-jalan.show', compact('rawatJalan'));
    }

    public function edit(RawatJalan $rawatJalan): View
    {
        $rawatJalan->load('pasien.user', 'dokter.user', 'poli');
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();
        $polis = Poli::all();

        return view('petugas.rawat-jalan.edit', compact('rawatJalan', 'pasiens', 'dokters', 'polis'));
    }

    public function update(UpdateRawatJalanRequest $request, RawatJalan $rawatJalan): RedirectResponse
    {
        $rawatJalan->update($request->validated());

        return redirect()
            ->route('petugas.rawat-jalan.show', $rawatJalan)
            ->with('success', 'Data Rawat Jalan berhasil diperbarui');
    }

    public function destroy(RawatJalan $rawatJalan): RedirectResponse
    {
        $rawatJalan->delete();

        return redirect()
            ->route('petugas.rawat-jalan.index')
            ->with('success', 'Data Rawat Jalan berhasil dihapus');
    }
}
