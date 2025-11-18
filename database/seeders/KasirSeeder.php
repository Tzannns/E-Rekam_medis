<?php

namespace Database\Seeders;

use App\Models\KasirPembayaran;
use App\Models\KasirTransaksi;
use App\Models\KasirTransaksiItem;
use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class KasirSeeder extends Seeder
{
    public function run(): void
    {
        $pasien = Pasien::query()->first();
        if (! $pasien) {
            return;
        }

        $this->buatTransaksi($pasien->id, [
            ['deskripsi' => 'Biaya Konsultasi', 'qty' => 1, 'harga' => 150000],
            ['deskripsi' => 'Laboratorium Hematologi', 'qty' => 1, 'harga' => 200000],
        ], 0, 'Lunas', 350000);

        $this->buatTransaksi($pasien->id, [
            ['deskripsi' => 'Radiologi Rontgen', 'qty' => 1, 'harga' => 300000],
            ['deskripsi' => 'Obat Reseptum', 'qty' => 2, 'harga' => 50000],
        ], 50000, 'Sebagian', 200000);

        $this->buatTransaksi($pasien->id, [
            ['deskripsi' => 'Rawat Jalan - Pemeriksaan', 'qty' => 1, 'harga' => 100000],
        ], 0, 'Menunggu', 0);
    }

    private function buatTransaksi(int $pasienId, array $items, float $diskon, string $targetStatus, float $bayarAwal): void
    {
        $subtotal = 0;
        foreach ($items as $it) {
            $subtotal += $it['qty'] * $it['harga'];
        }

        $total = max($subtotal - $diskon, 0);
        $nomor = 'INV-'.now()->format('YmdHis').'-'.sprintf('%03d', random_int(1, 999));

        $trx = KasirTransaksi::create([
            'pasien_id' => $pasienId,
            'nomor_invoice' => $nomor,
            'tanggal' => Carbon::now(),
            'subtotal' => $subtotal,
            'diskon' => $diskon,
            'total' => $total,
            'status' => 'Menunggu',
        ]);

        foreach ($items as $it) {
            KasirTransaksiItem::create([
                'transaksi_id' => $trx->id,
                'deskripsi' => $it['deskripsi'],
                'qty' => $it['qty'],
                'harga' => $it['harga'],
                'total' => $it['qty'] * $it['harga'],
            ]);
        }

        if ($bayarAwal > 0) {
            $jumlah = min($bayarAwal, $total);
            KasirPembayaran::create([
                'transaksi_id' => $trx->id,
                'tanggal' => Carbon::now(),
                'metode' => 'Tunai',
                'jumlah' => $jumlah,
                'referensi' => 'SEED',
            ]);
        }

        $dibayar = (float) $trx->pembayaran()->sum('jumlah');
        $trx->status = $dibayar >= (float) $trx->total ? 'Lunas' : ($dibayar > 0 ? 'Sebagian' : 'Menunggu');
        if ($targetStatus === 'Menunggu' || $targetStatus === 'Sebagian' || $targetStatus === 'Lunas') {
            $trx->status = $targetStatus;
        }
        $trx->save();
    }
}
