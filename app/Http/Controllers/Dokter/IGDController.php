<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateIGDRequest;
use App\Models\Dokter;
use App\Models\IGD;
use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IGDController extends Controller
{
    public function index(): View
    {
        $igds = IGD::with('pasien.user', 'dokter.user')
            ->latest('tanggal_masuk')
            ->paginate(10);

        return view('dokter.igd.index', compact('igds'));
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
