<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\IGD;
use App\Models\Pasien;
use Illuminate\Database\Seeder;

class IGDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get default pasien and dokter (created in DatabaseSeeder)
        $defaultPasien = Pasien::first();
        $defaultDokter = Dokter::first();

        // Only create IGD records if default pasien and dokter exist
        if ($defaultPasien && $defaultDokter) {
            IGD::factory(15)->create([
                'pasien_id' => $defaultPasien->id,
                'dokter_id' => $defaultDokter->id,
            ]);
        }
    }
}
