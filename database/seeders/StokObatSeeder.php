<?php

namespace Database\Seeders;

use App\Models\Obat;
use App\Models\StokObat;
use App\Models\User;
use Illuminate\Database\Seeder;

class StokObatSeeder extends Seeder
{
    public function run(): void
    {
        // Only create if no stok obat exists
        if (StokObat::count() > 0) {
            return;
        }

        $obats = Obat::all();
        $admin = User::where('email', 'admin@rekammedis.com')->first();

        if ($obats->isEmpty() || ! $admin) {
            $this->command->warn('Pastikan Obat dan User sudah di-seed terlebih dahulu');

            return;
        }

        // Buat riwayat stok masuk awal untuk setiap obat
        foreach ($obats as $obat) {
            StokObat::create([
                'obat_id' => $obat->id,
                'user_id' => $admin->id,
                'tipe' => 'Masuk',
                'jumlah' => $obat->stok,
                'stok_sebelum' => 0,
                'stok_sesudah' => $obat->stok,
                'keterangan' => 'Stok awal',
                'no_referensi' => 'PO-'.now()->format('Ymd').'-'.str_pad($obat->id, 4, '0', STR_PAD_LEFT),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        // Tambahkan beberapa riwayat stok masuk/keluar random
        $obatSample = $obats->random(5);

        foreach ($obatSample as $obat) {
            // Stok masuk tambahan
            $stokSebelum = $obat->stok;
            $jumlahMasuk = rand(10, 50);
            $stokSesudah = $stokSebelum + $jumlahMasuk;

            StokObat::create([
                'obat_id' => $obat->id,
                'user_id' => $admin->id,
                'tipe' => 'Masuk',
                'jumlah' => $jumlahMasuk,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'keterangan' => 'Pembelian dari supplier',
                'no_referensi' => 'PO-'.now()->format('Ymd').'-'.str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                'created_at' => now()->subDays(rand(1, 15)),
            ]);

            // Update stok obat
            $obat->update(['stok' => $stokSesudah]);

            // Stok keluar (penjualan)
            $stokSebelum = $stokSesudah;
            $jumlahKeluar = rand(5, 20);
            $stokSesudah = $stokSebelum - $jumlahKeluar;

            StokObat::create([
                'obat_id' => $obat->id,
                'user_id' => $admin->id,
                'tipe' => 'Keluar',
                'jumlah' => $jumlahKeluar,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'keterangan' => 'Penjualan',
                'no_referensi' => 'APT-'.now()->format('Ymd').'-'.str_pad(rand(1, 100), 4, '0', STR_PAD_LEFT),
                'created_at' => now()->subDays(rand(1, 7)),
            ]);

            // Update stok obat
            $obat->update(['stok' => $stokSesudah]);
        }

        $this->command->info('Stok obat seeder completed!');
    }
}
