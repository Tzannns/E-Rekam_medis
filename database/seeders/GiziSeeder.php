<?php

namespace Database\Seeders;

use App\Models\Gizi;
use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class GiziSeeder extends Seeder
{
    public function run(): void
    {
        if (Gizi::query()->exists()) {
            return;
        }

        $pasienList = Pasien::query()->pluck('id');
        if ($pasienList->isEmpty()) {
            return;
        }

        $foods = [
            'Diet Rendah Garam',
            'Diet Diabetes',
            'Diet Lunak',
            'Diet Tinggi Protein',
            'Makanan Cair',
            'MP-ASI',
        ];
        $statuses = ['pending', 'diberikan', 'ditolak'];
        $cautions = [
            'Perhatikan alergi',
            'Berikan secara bertahap',
            'Harus diberikan selama rawat inap',
            'Konsultasi dengan gizi',
            'Makanan harus hangat',
            null,
        ];

        for ($i = 0; $i < 30; $i++) {
            Gizi::create([
                'pasien_id' => $pasienList->random(),
                'tanggal' => Carbon::now()->subDays(rand(0, 20)),
                'jenis_makanan' => $foods[array_rand($foods)],
                'jumlah' => rand(1, 4),
                'catatan' => $cautions[array_rand($cautions)],
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}
