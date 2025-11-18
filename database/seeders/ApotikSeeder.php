<?php

namespace Database\Seeders;

use App\Models\Apotik;
use Illuminate\Database\Seeder;

class ApotikSeeder extends Seeder
{
    public function run(): void
    {
        // Only create if no apotik exists
        if (Apotik::count() === 0) {
            Apotik::factory(15)->create();
        }
    }
}
