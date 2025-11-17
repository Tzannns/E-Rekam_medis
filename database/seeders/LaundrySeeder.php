<?php

namespace Database\Seeders;

use App\Models\Laundry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LaundrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Laundry::query()->exists()) {
            return;
        }

        $units = ['IGD', 'Rawat Inap', 'Rawat Jalan', 'Radiologi', 'Laboratorium', 'Kamar Operasi'];
        $items = ['Linen Tempat Tidur', 'Selimut', 'Gorden', 'Seragam Petugas', 'Handuk', 'Sarung Bantal'];
        $types = ['Putih', 'Warna', 'Jahit', 'Setrika'];
        $statuses = ['Menunggu', 'Sedang Diproses', 'Selesai'];
        $cautions = [
            'Urgent - Khusus IGD',
            'Gunakan pemutih',
            'Jangan bleach',
            'Hati-hati lipatan',
            null,
        ];

        $rows = [];
        for ($i = 0; $i < 40; $i++) {
            $tanggalMasuk = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $status = $statuses[array_rand($statuses)];
            $tanggalSelesai = null;

            if ($status === 'Selesai') {
                $tanggalSelesai = (clone $tanggalMasuk)->addDays(rand(1, 5))->addHours(rand(1, 12));
            }

            $rows[] = [
                'unit' => $units[array_rand($units)],
                'item' => $items[array_rand($items)],
                'jenis' => $types[array_rand($types)],
                'jumlah' => rand(2, 30),
                'berat_kg' => round(rand(2, 50) / 2, 1),
                'tanggal_masuk' => $tanggalMasuk,
                'tanggal_selesai' => $tanggalSelesai,
                'status' => $status,
                'catatan' => $cautions[array_rand($cautions)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Laundry::query()->insert($rows);
    }
}
