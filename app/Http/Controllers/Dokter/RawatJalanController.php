<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRawatJalanRequest;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\RawatJalan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RawatJalanController extends Controller
{
    public function index(): View
    {
        $rawatJalans = RawatJalan::with('pasien.user', 'dokter.user', 'poli')
            ->latest('tanggal_kunjungan')
            ->paginate(10);

        return view('dokter.rawat-jalan.index', compact('rawatJalans'));
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
