<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\StokObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokObatController extends Controller
{
    public function index()
    {
        $search = request('search');
        $tipe = request('tipe');

        $stokObats = StokObat::with(['obat', 'user'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('obat', function ($q) use ($search) {
                    $q->where('nama_obat', 'like', "%{$search}%")
                        ->orWhere('kode_obat', 'like', "%{$search}%");
                });
            })
            ->when($tipe && $tipe !== 'semua', function ($query) use ($tipe) {
                return $query->where('tipe', $tipe);
            })
            ->latest()
            ->paginate(15);

        return view('admin.apotik.stok.index', compact('stokObats'));
    }

    public function create()
    {
        $obats = Obat::where('status', '!=', 'Kadaluarsa')->get();

        return view('admin.apotik.stok.create', compact('obats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'tipe' => 'required|in:Masuk,Keluar,Retur,Adjustment',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'no_referensi' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated) {
            $obat = Obat::findOrFail($validated['obat_id']);

            $stokSebelum = $obat->stok;

            // Calculate new stock based on type
            if (in_array($validated['tipe'], ['Masuk', 'Retur'])) {
                $stokSesudah = $stokSebelum + $validated['jumlah'];
            } else {
                $stokSesudah = $stokSebelum - $validated['jumlah'];

                if ($stokSesudah < 0) {
                    throw new \Exception('Stok tidak mencukupi');
                }
            }

            // Create stock record
            StokObat::create([
                'obat_id' => $validated['obat_id'],
                'user_id' => auth()->id(),
                'tipe' => $validated['tipe'],
                'jumlah' => $validated['jumlah'],
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'keterangan' => $validated['keterangan'],
                'no_referensi' => $validated['no_referensi'],
            ]);

            // Update obat stock
            $obat->update([
                'stok' => $stokSesudah,
                'status' => $stokSesudah > 0 ? 'Tersedia' : 'Habis',
            ]);
        });

        return redirect()->route('admin.apotik.stok.index')
            ->with('success', 'Stok obat berhasil diperbarui');
    }

    public function show(StokObat $stok)
    {
        $stok->load(['obat', 'user']);

        return view('admin.apotik.stok.show', compact('stok'));
    }
}
