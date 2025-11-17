<?php

namespace Database\Seeders;

use App\Models\Apotik;
use App\Models\DetailTransaksiApotik;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\TransaksiApotik;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransaksiApotikSeeder extends Seeder
{
    public function run(): void
    {
        // Only create if no transaksi exists
        if (TransaksiApotik::count() > 0) {
            return;
        }

        $apotik = Apotik::first();
        $admin = User::where('email', 'admin@rekammedis.com')->first();
        $pasiens = Pasien::all();
        $obats = Obat::where('stok', '>', 0)->get();

        if (!$apotik || !$admin || $obats->isEmpty()) {
            $this->command->warn('Pastikan Apotik, User, dan Obat sudah di-seed terlebih dahulu');
            return;
        }

        // Buat 10 transaksi sample
        for ($i = 1; $i <= 10; $i++) {
            $tipePembeli = rand(0, 1) ? 'Pasien' : 'Umum';
            $pasien = $pasiens->isNotEmpty() ? $pasiens->random() : null;

            // Pilih 1-3 obat random
            $jumlahObat = rand(1, 3);
            $selectedObats = $obats->random(min($jumlahObat, $obats->count()));

            $subtotal = 0;
            $items = [];

            foreach ($selectedObats as $obat) {
                $jumlah = rand(1, 3);
                $hargaSatuan = $obat->harga_jual;
                $itemSubtotal = $hargaSatuan * $jumlah;
                $subtotal += $itemSubtotal;

                $items[] = [
                    'obat_id' => $obat->id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $hargaSatuan,
                    'diskon' => 0,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $diskon = 0;
            $pajak = 0;
            $total = $subtotal - $diskon + $pajak;
            
            // Pembayaran dengan kembalian
            $bayar = ceil($total / 10000) * 10000; // Bulatkan ke atas 10rb
            $kembalian = $bayar - $total;

            // Generate nomor transaksi
            $date = now()->subDays(rand(0, 30))->format('Ymd');
            $noTransaksi = 'APT-' . $date . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            // Buat transaksi
            $transaksi = TransaksiApotik::create([
                'no_transaksi' => $noTransaksi,
                'apotik_id' => $apotik->id,
                'pasien_id' => $tipePembeli === 'Pasien' && $pasien ? $pasien->id : null,
                'user_id' => $admin->id,
                'nama_pembeli' => $tipePembeli === 'Umum' ? 'Pembeli ' . $i : null,
                'tipe_pembeli' => $tipePembeli,
                'subtotal' => $subtotal,
                'diskon' => $diskon,
                'pajak' => $pajak,
                'total' => $total,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
                'metode_pembayaran' => ['Tunai', 'Debit', 'Transfer'][rand(0, 2)],
                'status' => 'Selesai',
                'catatan' => rand(0, 1) ? 'Transaksi normal' : null,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);

            // Buat detail transaksi
            foreach ($items as $item) {
                DetailTransaksiApotik::create([
                    'transaksi_apotik_id' => $transaksi->id,
                    'obat_id' => $item['obat_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'diskon' => $item['diskon'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        }

        $this->command->info('Transaksi apotik seeder completed!');
    }
}
