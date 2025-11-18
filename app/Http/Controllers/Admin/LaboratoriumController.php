<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Laboratorium;
use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaboratoriumController extends Controller
{
    public function index(Request $request): View
    {
        $query = Laboratorium::with(['pasien.user', 'dokter.user']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis_pemeriksaan', 'like', "%{$search}%")
                    ->orWhere('hasil', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%")
                    ->orWhereHas('pasien.user', function ($qq) use ($search) {
                        $qq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dokter.user', function ($qq) use ($search) {
                        $qq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('pasien_id') && $request->pasien_id) {
            $query->where('pasien_id', $request->pasien_id);
        }

        if ($request->has('dokter_id') && $request->dokter_id) {
            $query->where('dokter_id', $request->dokter_id);
        }

        if ($request->has('jenis_pemeriksaan') && $request->jenis_pemeriksaan) {
            $query->where('jenis_pemeriksaan', 'like', "%{$request->jenis_pemeriksaan}%");
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_periksa', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_periksa', '<=', $request->tanggal_sampai.' 23:59:59');
        }

        $labs = $query->latest('tanggal_periksa')->paginate(15);
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view('admin.laboratorium.index', compact('labs', 'pasienList', 'dokterList'));
    }

    public function create(): View
    {
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view('admin.laboratorium.create', compact('pasienList', 'dokterList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'pasien_id' => ['required', 'exists:pasien,id'],
            'dokter_id' => ['required', 'exists:dokter,id'],
            'jenis_pemeriksaan' => ['required', 'string', 'max:255'],
            'hasil' => ['nullable', 'string'],
            'nilai_rujukan' => ['nullable', 'string', 'max:255'],
            'satuan' => ['nullable', 'string', 'max:100'],
            'tanggal_periksa' => ['required', 'date_format:Y-m-d\TH:i'],
            'status' => ['required', 'in:Diajukan,Diproses,Selesai'],
            'catatan' => ['nullable', 'string'],
        ]);

        $lab = Laboratorium::create($data);

        return redirect()->route('admin.laboratorium.show', $lab)->with('success', 'Data laboratorium berhasil ditambahkan');
    }

    public function show(Laboratorium $laboratorium): View
    {
        return view('admin.laboratorium.show', ['lab' => $laboratorium]);
    }

    public function edit(Laboratorium $laboratorium): View
    {
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view('admin.laboratorium.edit', ['lab' => $laboratorium, 'pasienList' => $pasienList, 'dokterList' => $dokterList]);
    }

    public function update(Request $request, Laboratorium $laboratorium): RedirectResponse
    {
        $data = $request->validate([
            'pasien_id' => ['required', 'exists:pasien,id'],
            'dokter_id' => ['required', 'exists:dokter,id'],
            'jenis_pemeriksaan' => ['required', 'string', 'max:255'],
            'hasil' => ['nullable', 'string'],
            'nilai_rujukan' => ['nullable', 'string', 'max:255'],
            'satuan' => ['nullable', 'string', 'max:100'],
            'tanggal_periksa' => ['required', 'date_format:Y-m-d\TH:i'],
            'status' => ['required', 'in:Diajukan,Diproses,Selesai'],
            'catatan' => ['nullable', 'string'],
        ]);

        $laboratorium->update($data);

        return redirect()->route('admin.laboratorium.show', $laboratorium)->with('success', 'Data laboratorium berhasil diperbarui');
    }

    public function destroy(Laboratorium $laboratorium): RedirectResponse
    {
        $laboratorium->delete();

        return redirect()->route('admin.laboratorium.index')->with('success', 'Data laboratorium berhasil dihapus');
    }
}
