<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apotik;
use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $search = request('search');
        $kategori = request('kategori');
        $status = request('status');

        $obats = Obat::with(['apotik', 'supplier'])
            ->when($search, function ($query, $search) {
                return $query->where('nama_obat', 'like', "%{$search}%")
                    ->orWhere('kode_obat', 'like', "%{$search}%");
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($status && $status !== 'semua', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        $kategoris = Obat::distinct()->pluck('kategori');
        $lowStockCount = Obat::whereColumn('stok', '<=', 'stok_minimum')->count();
        $expiredCount = Obat::where('tanggal_kadaluarsa', '<', now())->count();

        return view('admin.apotik.obat.index', compact('obats', 'kategoris', 'lowStockCount', 'expiredCount'));
    }

    public function create()
    {
        $apotiks = Apotik::where('status', 'Aktif')->get();
        $suppliers = Supplier::where('status', 'Aktif')->get();

        return view('admin.apotik.obat.create', compact('apotiks', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'apotik_id' => 'required|exists:apotiks,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'kode_obat' => 'required|string|max:50|unique:obats',
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'no_batch' => 'nullable|string|max:100',
        ]);

        $validated['status'] = $validated['stok'] > 0 ? 'Tersedia' : 'Habis';

        Obat::create($validated);

        return redirect()->route('admin.apotik.obat.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function show(Obat $obat)
    {
        $obat->load(['apotik', 'supplier', 'stokObats.user']);

        return view('admin.apotik.obat.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        $apotiks = Apotik::where('status', 'Aktif')->get();
        $suppliers = Supplier::where('status', 'Aktif')->get();

        return view('admin.apotik.obat.edit', compact('obat', 'apotiks', 'suppliers'));
    }

    public function update(Request $request, Obat $obat)
    {
        $validated = $request->validate([
            'apotik_id' => 'required|exists:apotiks,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
            'no_batch' => 'nullable|string|max:100',
            'status' => 'required|in:Tersedia,Habis,Kadaluarsa',
        ]);

        $obat->update($validated);

        return redirect()->route('admin.apotik.obat.show', $obat)
            ->with('success', 'Data obat berhasil diperbarui');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('admin.apotik.obat.index')
            ->with('success', 'Data obat berhasil dihapus');
    }
}
