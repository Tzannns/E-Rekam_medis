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

        $units = ['IGD', 'Rawat Inap', 'Rawat Jalan', 'Radiologi', 'Laboratorium'];
        $items = ['Linen Tempat Tidur', 'Selimut', 'Gorden', 'Seragam', 'Handuk'];
        $statuses = ['Menunggu', 'Sedang Diproses', 'Selesai'];

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'unit' => $units[array_rand($units)],
                'item' => $items[array_rand($items)],
                'jumlah' => rand(1, 25),
                'tanggal_masuk' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                'status' => $statuses[array_rand($statuses)],
                'catatan' => rand(0, 1) ? 'Urgent' : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Laundry::query()->insert($rows);
    }
}