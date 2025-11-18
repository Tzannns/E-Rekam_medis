<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRawatInapRequest;
use App\Http\Requests\UpdateRawatInapRequest;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatInap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RawatInapController extends Controller
{
    public function index(Request $request): View
    {
        $query = RawatInap::with('pasien.user', 'dokter.user');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pasien.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('dokter.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('diagnosa', 'like', "%{$search}%")
                    ->orWhere('ruang', 'like', "%{$search}%");
            });
        }

        // Filter by pasien
        if ($request->has('pasien_id') && $request->pasien_id) {
            $query->where('pasien_id', $request->pasien_id);
        }

        // Filter by dokter
        if ($request->has('dokter_id') && $request->dokter_id) {
            $query->where('dokter_id', $request->dokter_id);
        }

        // Filter by ruang
        if ($request->has('ruang') && $request->ruang) {
            $query->where('ruang', $request->ruang);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by tanggal masuk
        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_masuk', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_masuk', '<=', $request->tanggal_sampai);
        }

        $rawatInaps = $query->latest('tanggal_masuk')->paginate(15);
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view('admin.rawat-inap.index', compact('rawatInaps', 'pasienList', 'dokterList'));
    }

    public function create(): View
    {
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();

        return view('admin.rawat-inap.create', compact('pasiens', 'dokters'));
    }

    public function store(StoreRawatInapRequest $request): RedirectResponse
    {
        $rawatInap = RawatInap::create($request->validated());

        $prefix = \Illuminate\Support\Str::startsWith(\Illuminate\Support\Facades\Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin';

        return redirect()
            ->route($prefix.'.rawat-inap.show', $rawatInap)
            ->with('success', 'Data Rawat Inap berhasil ditambahkan');
    }

    public function show(RawatInap $rawatInap): View
    {
        $rawatInap->load('pasien.user', 'dokter.user');

        return view('admin.rawat-inap.show', compact('rawatInap'));
    }

    public function edit(RawatInap $rawatInap): View
    {
        $rawatInap->load('pasien.user', 'dokter.user');
        $pasiens = Pasien::with('user')->get();
        $dokters = Dokter::with('user')->get();

        return view('admin.rawat-inap.edit', compact('rawatInap', 'pasiens', 'dokters'));
    }

    public function update(UpdateRawatInapRequest $request, RawatInap $rawatInap): RedirectResponse
    {
        $rawatInap->update($request->validated());

        $prefix = \Illuminate\Support\Str::startsWith(\Illuminate\Support\Facades\Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin';

        return redirect()
            ->route($prefix.'.rawat-inap.show', $rawatInap)
            ->with('success', 'Data Rawat Inap berhasil diperbarui');
    }

    public function destroy(RawatInap $rawatInap): RedirectResponse
    {
        $rawatInap->delete();

        $prefix = \Illuminate\Support\Str::startsWith(\Illuminate\Support\Facades\Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin';

        return redirect()
            ->route($prefix.'.rawat-inap.index')
            ->with('success', 'Data Rawat Inap berhasil dihapus');
    }
}
