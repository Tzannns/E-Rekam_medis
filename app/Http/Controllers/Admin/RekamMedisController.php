<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRekamMedisRequest;
use App\Http\Requests\Admin\UpdateRekamMedisRequest;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class RekamMedisController extends Controller
{
    protected function getPrefix(): string
    {
        return Str::startsWith(Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin';
    }

    protected function getView(string $view): string
    {
        $prefix = $this->getPrefix();

        return "{$prefix}.rekam-medis.{$view}";
    }

    public function index(Request $request): View
    {
        $query = RekamMedis::with(['pasien.user', 'dokter.user']);

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
                    ->orWhere('keluhan', 'like', "%{$search}%");
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

        // Filter by tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_periksa', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_periksa', '<=', $request->tanggal_sampai);
        }

        $rekamMedis = $query->latest()->paginate(15);
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view($this->getView('index'), compact('rekamMedis', 'pasienList', 'dokterList'));
    }

    public function create(): View
    {
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view($this->getView('create'), compact('pasienList', 'dokterList'));
    }

    public function store(StoreRekamMedisRequest $request): RedirectResponse
    {
        RekamMedis::create($request->validated());

        $prefix = $this->getPrefix();

        return redirect()->route($prefix.'.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function show(RekamMedis $rekamMedi): View
    {
        $rekamMedi->load(['pasien.user', 'dokter.user']);

        return view($this->getView('show'), compact('rekamMedi'));
    }

    public function edit(RekamMedis $rekamMedi): View
    {
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view($this->getView('edit'), compact('rekamMedi', 'pasienList', 'dokterList'));
    }

    public function update(UpdateRekamMedisRequest $request, RekamMedis $rekamMedi): RedirectResponse
    {
        $rekamMedi->update($request->validated());

        $prefix = $this->getPrefix();

        return redirect()->route($prefix.'.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy(RekamMedis $rekamMedi): RedirectResponse
    {
        $rekamMedi->delete();

        $prefix = $this->getPrefix();

        return redirect()->route($prefix.'.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dihapus.');
    }

    public function data(Request $request): JsonResponse
    {
        $query = RekamMedis::query()->with(['pasien.user', 'dokter.user']);

        return DataTables::eloquent($query)
            ->addColumn('pasien', function (RekamMedis $rm) {
                return $rm->pasien?->user?->name ?? '-';
            })
            ->addColumn('dokter', function (RekamMedis $rm) {
                return $rm->dokter?->user?->name ?? '-';
            })
            ->addColumn('tanggal', function (RekamMedis $rm) {
                return optional($rm->tanggal_periksa)->format('Y-m-d');
            })
            ->addColumn('actions', function (RekamMedis $rm) {
                return view('admin.rekam-medis.partials.actions', ['rekam' => $rm])->render();
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
}
