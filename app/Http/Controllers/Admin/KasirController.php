<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KasirPembayaran;
use App\Models\KasirTransaksi;
use App\Models\KasirTransaksiItem;
use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class KasirController extends Controller
{
    public function index(Request $request): View
    {
        $query = KasirTransaksi::with(['pasien.user'])->latest('tanggal');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_invoice', 'like', "%{$search}%")
                    ->orWhereHas('pasien.user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $transaksi = $query->paginate(15);
        return view('admin.kasir.index', compact('transaksi'));
    }

    public function create(): View
    {
        $pasienList = Pasien::with('user')->get();
        return view('admin.kasir.create', compact('pasienList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'pasien_id' => ['required', 'exists:pasien,id'],
            'tanggal' => ['required', 'date_format:Y-m-d\TH:i'],
            'diskon' => ['nullable', 'numeric', 'min:0'],
            'catatan' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.deskripsi' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.harga' => ['required', 'numeric', 'min:0'],
        ]);

        $tanggal = Carbon::parse($data['tanggal']);
        $subtotal = 0;
        foreach ($data['items'] as $it) {
            $subtotal += ($it['qty'] * $it['harga']);
        }
        $diskon = isset($data['diskon']) ? (float) $data['diskon'] : 0.0;
        $total = max($subtotal - $diskon, 0);

        $nomor = 'INV-' . now()->format('YmdHis') . '-' . sprintf('%03d', random_int(1, 999));

        $trx = KasirTransaksi::create([
            'pasien_id' => $data['pasien_id'],
            'nomor_invoice' => $nomor,
            'tanggal' => $tanggal,
            'subtotal' => $subtotal,
            'diskon' => $diskon,
            'total' => $total,
            'status' => 'Menunggu',
            'catatan' => $data['catatan'] ?? null,
        ]);

        foreach ($data['items'] as $it) {
            KasirTransaksiItem::create([
                'transaksi_id' => $trx->id,
                'deskripsi' => $it['deskripsi'],
                'qty' => $it['qty'],
                'harga' => $it['harga'],
                'total' => $it['qty'] * $it['harga'],
            ]);
        }

        return redirect()->route('admin.kasir.show', $trx)->with('success', 'Transaksi kasir berhasil dibuat');
    }

    public function show(KasirTransaksi $kasir): View
    {
        $kasir->load(['pasien.user', 'items', 'pembayaran']);
        $dibayar = (float) $kasir->pembayaran()->sum('jumlah');
        $sisa = max((float) $kasir->total - $dibayar, 0);
        return view('admin.kasir.show', compact('kasir', 'dibayar', 'sisa'));
    }

    public function tambahPembayaran(Request $request, KasirTransaksi $kasir): RedirectResponse
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date_format:Y-m-d\TH:i'],
            'metode' => ['required', 'in:Tunai,Kartu,Transfer,BPJS'],
            'jumlah' => ['required', 'numeric', 'min:0.01'],
            'referensi' => ['nullable', 'string', 'max:255'],
        ]);

        $dibayar = (float) $kasir->pembayaran()->sum('jumlah');
        $sisa = max((float) $kasir->total - $dibayar, 0);

        $jumlah = (float) $data['jumlah'];
        if ($jumlah > $sisa) {
            $jumlah = $sisa;
        }

        KasirPembayaran::create([
            'transaksi_id' => $kasir->id,
            'tanggal' => Carbon::parse($data['tanggal']),
            'metode' => $data['metode'],
            'jumlah' => $jumlah,
            'referensi' => $data['referensi'] ?? null,
        ]);

        $dibayarBaru = (float) $kasir->pembayaran()->sum('jumlah');
        $kasir->status = $dibayarBaru >= (float) $kasir->total ? 'Lunas' : ($dibayarBaru > 0 ? 'Sebagian' : 'Menunggu');
        $kasir->save();

        return redirect()->route('admin.kasir.show', $kasir)->with('success', 'Pembayaran berhasil ditambahkan');
    }
}
