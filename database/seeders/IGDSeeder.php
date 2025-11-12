<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\IGD;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Seeder;

class IGDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample pasiens with users
        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create(['name' => "Pasien $i"]);
            Pasien::factory()->for($user, 'user')->create();
        }

        // Create sample dokters with users
        for ($i = 1; $i <= 3; $i++) {
            $user = User::factory()->create(['name' => "Dokter $i"]);
            Dokter::factory()->for($user, 'user')->create();
        }

        // Create sample IGD records
        IGD::factory(15)->create();
    }
}
