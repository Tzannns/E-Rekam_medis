<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StorageItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorageController extends Controller
{
    public function index(): View
    {
        $search = request('search');
        $kategori = request('kategori');
        $status = request('status');

        $items = StorageItem::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%");
            })
            ->when($kategori && $kategori !== 'semua', function ($query) use ($kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($status && $status !== 'semua', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        $totalStok = StorageItem::where('status', 'Aktif')->count();
        $stokRendah = StorageItem::where('status', 'Aktif')
            ->whereRaw('stok_saat_ini <= stok_minimal')
            ->count();
        $totalNilai = StorageItem::where('status', 'Aktif')->sum('total_nilai');

        return view('admin.storage.index', compact('items', 'totalStok', 'stokRendah', 'totalNilai'));
    }

    public function create(): View
    {
        return view('admin.storage.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:storage_items',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:Obat,Alat Medis,Consumable,Lainnya',
            'deskripsi' => 'nullable|string',
            'stok_awal' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga_satuan' => 'required|numeric|min:0',
            'lokasi' => 'nullable|string|max:100',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'nullable|date|after:tanggal_masuk',
            'supplier' => 'nullable|string|max:255',
            'nomor_batch' => 'nullable|string|max:100',
        ]);

        $validated['stok_saat_ini'] = $validated['stok_awal'];
        $validated['total_nilai'] = $validated['stok_awal'] * $validated['harga_satuan'];

        StorageItem::create($validated);

        return redirect()->route('admin.storage.index')
            ->with('success', 'Barang storage berhasil ditambahkan');
    }

    public function show(StorageItem $storage): View
    {
        return view('admin.storage.show', compact('storage'));
    }

    public function edit(StorageItem $storage): View
    {
        return view('admin.storage.edit', compact('storage'));
    }

    public function update(Request $request, StorageItem $storage)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:Obat,Alat Medis,Consumable,Lainnya',
            'deskripsi' => 'nullable|string',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga_satuan' => 'required|numeric|min:0',
            'lokasi' => 'nullable|string|max:100',
            'tanggal_kadaluarsa' => 'nullable|date',
            'status' => 'required|in:Aktif,Nonaktif,Kadaluarsa',
            'supplier' => 'nullable|string|max:255',
            'nomor_batch' => 'nullable|string|max:100',
        ]);

        $validated['total_nilai'] = $validated['stok_saat_ini'] * $validated['harga_satuan'];

        $storage->update($validated);

        return redirect()->route('admin.storage.show', $storage)
            ->with('success', 'Data storage berhasil diperbarui');
    }

    public function destroy(StorageItem $storage)
    {
        $storage->delete();

        return redirect()->route('admin.storage.index')
            ->with('success', 'Data storage berhasil dihapus');
    }
}
