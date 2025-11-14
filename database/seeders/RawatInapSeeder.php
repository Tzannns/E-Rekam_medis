<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatInap;
use Illuminate\Database\Seeder;

class RawatInapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get default pasien and dokter (created in DatabaseSeeder)
        $defaultPasien = Pasien::first();
        $defaultDokter = Dokter::first();

        // Only create RawatInap records if default pasien and dokter exist
        if ($defaultPasien && $defaultDokter) {
            RawatInap::factory(8)->create([
                'pasien_id' => $defaultPasien->id,
                'dokter_id' => $defaultDokter->id,
            ]);
        }
    }
}
