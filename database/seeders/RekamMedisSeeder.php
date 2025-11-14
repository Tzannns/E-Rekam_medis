<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Database\Seeder;

class RekamMedisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get default pasien and dokter (created in DatabaseSeeder)
        $defaultPasien = Pasien::first();
        $defaultDokter = Dokter::first();

        // Only create RekamMedis records if default pasien and dokter exist
        if ($defaultPasien && $defaultDokter) {
            RekamMedis::factory(8)->create([
                'pasien_id' => $defaultPasien->id,
                'dokter_id' => $defaultDokter->id,
            ]);
        }
    }
}
