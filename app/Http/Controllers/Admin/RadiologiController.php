<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Radiologi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RadiologiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Radiologi::with(['pasien.user', 'dokter.user']);

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

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_periksa', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_periksa', '<=', $request->tanggal_sampai.' 23:59:59');
        }

        $items = $query->latest('tanggal_periksa')->paginate(15);
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view('admin.radiologi.index', compact('items', 'pasienList', 'dokterList'));
    }

    public function create(): View
    {
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view('admin.radiologi.create', compact('pasienList', 'dokterList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'pasien_id' => ['required', 'exists:pasien,id'],
            'dokter_id' => ['required', 'exists:dokter,id'],
            'jenis_pemeriksaan' => ['required', 'string', 'max:255'],
            'hasil' => ['nullable', 'string'],
            'tanggal_periksa' => ['required', 'date_format:Y-m-d\TH:i'],
            'status' => ['required', 'in:Diajukan,Diproses,Selesai'],
            'catatan' => ['nullable', 'string'],
        ]);

        $item = Radiologi::create($data);

        return redirect()->route('admin.radiologi.show', $item)->with('success', 'Data radiologi berhasil ditambahkan');
    }

    public function show(Radiologi $radiologi): View
    {
        return view('admin.radiologi.show', ['item' => $radiologi]);
    }

    public function edit(Radiologi $radiologi): View
    {
        $pasienList = Pasien::with('user')->get();
        $dokterList = Dokter::with('user')->get();

        return view('admin.radiologi.edit', ['item' => $radiologi, 'pasienList' => $pasienList, 'dokterList' => $dokterList]);
    }

    public function update(Request $request, Radiologi $radiologi): RedirectResponse
    {
        $data = $request->validate([
            'pasien_id' => ['required', 'exists:pasien,id'],
            'dokter_id' => ['required', 'exists:dokter,id'],
            'jenis_pemeriksaan' => ['required', 'string', 'max:255'],
            'hasil' => ['nullable', 'string'],
            'tanggal_periksa' => ['required', 'date_format:Y-m-d\TH:i'],
            'status' => ['required', 'in:Diajukan,Diproses,Selesai'],
            'catatan' => ['nullable', 'string'],
        ]);

        $radiologi->update($data);

        return redirect()->route('admin.radiologi.show', $radiologi)->with('success', 'Data radiologi berhasil diperbarui');
    }

    public function destroy(Radiologi $radiologi): RedirectResponse
    {
        $radiologi->delete();

        return redirect()->route('admin.radiologi.index')->with('success', 'Data radiologi berhasil dihapus');
    }
}
