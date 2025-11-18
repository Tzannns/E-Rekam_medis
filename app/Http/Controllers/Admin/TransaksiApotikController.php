<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apotik;
use App\Models\DetailTransaksiApotik;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\StokObat;
use App\Models\TransaksiApotik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiApotikController extends Controller
{
    public function index()
    {
        $search = request('search');
        $status = request('status');
        $tanggal = request('tanggal');

        $transaksis = TransaksiApotik::with(['apotik', 'pasien', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('no_transaksi', 'like', "%{$search}%")
                    ->orWhere('nama_pembeli', 'like', "%{$search}%")
                    ->orWhereHas('pasien', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->when($status && $status !== 'semua', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('created_at', $tanggal);
            })
            ->latest()
            ->paginate(15);

        $totalPenjualan = TransaksiApotik::where('status', 'Selesai')
            ->whereDate('created_at', now())
            ->sum('total');

        return view('admin.apotik.transaksi.index', compact('transaksis', 'totalPenjualan'));
    }

    public function create()
    {
        $apotiks = Apotik::where('status', 'Aktif')->get();
        $pasiens = Pasien::all();
        $obats = Obat::where('status', 'Tersedia')->where('stok', '>', 0)->get();

        return view('admin.apotik.transaksi.create', compact('apotiks', 'pasiens', 'obats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'apotik_id' => 'required|exists:apotiks,id',
            'tipe_pembeli' => 'required|in:Pasien,Umum',
            'pasien_id' => 'required_if:tipe_pembeli,Pasien|nullable|exists:pasiens,id',
            'nama_pembeli' => 'required_if:tipe_pembeli,Umum|nullable|string|max:255',
            'metode_pembayaran' => 'required|in:Tunai,Debit,Kredit,Transfer,BPJS',
            'bayar' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'obat_id' => 'required|array|min:1',
            'obat_id.*' => 'required|exists:obats,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            // Calculate totals
            $subtotal = 0;
            $items = [];

            foreach ($validated['obat_id'] as $index => $obatId) {
                $obat = Obat::findOrFail($obatId);
                $jumlah = $validated['jumlah'][$index];

                if ($obat->stok < $jumlah) {
                    throw new \Exception("Stok {$obat->nama_obat} tidak mencukupi");
                }

                $itemSubtotal = $obat->harga_jual * $jumlah;
                $subtotal += $itemSubtotal;

                $items[] = [
                    'obat' => $obat,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $obat->harga_jual,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $diskon = 0;
            $pajak = 0;
            $total = $subtotal - $diskon + $pajak;
            $kembalian = $validated['bayar'] - $total;

            if ($kembalian < 0) {
                throw new \Exception('Pembayaran kurang dari total');
            }

            // Create transaction
            $transaksi = TransaksiApotik::create([
                'no_transaksi' => TransaksiApotik::generateNoTransaksi(),
                'apotik_id' => $validated['apotik_id'],
                'pasien_id' => $validated['pasien_id'] ?? null,
                'user_id' => auth()->id(),
                'nama_pembeli' => $validated['nama_pembeli'] ?? null,
                'tipe_pembeli' => $validated['tipe_pembeli'],
                'subtotal' => $subtotal,
                'diskon' => $diskon,
                'pajak' => $pajak,
                'total' => $total,
                'bayar' => $validated['bayar'],
                'kembalian' => $kembalian,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'status' => 'Selesai',
                'catatan' => $validated['catatan'],
            ]);

            // Create transaction details and update stock
            foreach ($items as $item) {
                DetailTransaksiApotik::create([
                    'transaksi_apotik_id' => $transaksi->id,
                    'obat_id' => $item['obat']->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'diskon' => 0,
                    'subtotal' => $item['subtotal'],
                ]);

                // Update stock
                $obat = $item['obat'];
                $stokSebelum = $obat->stok;
                $stokSesudah = $stokSebelum - $item['jumlah'];

                StokObat::create([
                    'obat_id' => $obat->id,
                    'user_id' => auth()->id(),
                    'tipe' => 'Keluar',
                    'jumlah' => $item['jumlah'],
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'keterangan' => 'Penjualan - '.$transaksi->no_transaksi,
                    'no_referensi' => $transaksi->no_transaksi,
                ]);

                $obat->update([
                    'stok' => $stokSesudah,
                    'status' => $stokSesudah > 0 ? 'Tersedia' : 'Habis',
                ]);
            }
        });

        return redirect()->route('admin.apotik.transaksi.index')
            ->with('success', 'Transaksi berhasil disimpan');
    }

    public function show(TransaksiApotik $transaksi)
    {
        $transaksi->load(['apotik', 'pasien', 'user', 'details.obat']);

        return view('admin.apotik.transaksi.show', compact('transaksi'));
    }

    public function destroy(TransaksiApotik $transaksi)
    {
        if ($transaksi->status === 'Selesai') {
            return back()->with('error', 'Transaksi yang sudah selesai tidak dapat dihapus');
        }

        $transaksi->delete();

        return redirect()->route('admin.apotik.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}
