<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\RawatJalan;
use Illuminate\Database\Seeder;

class RawatJalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get default pasien, dokter, and poli
        $defaultPasien = Pasien::first();
        $defaultDokter = Dokter::first();
        $defaultPoli = Poli::first();

        // Only create RawatJalan records if default pasien, dokter, and poli exist
        if ($defaultPasien && $defaultDokter && $defaultPoli) {
            RawatJalan::factory(15)->create([
                'pasien_id' => $defaultPasien->id,
                'dokter_id' => $defaultDokter->id,
                'poli_id' => $defaultPoli->id,
            ]);
        }
    }
}
