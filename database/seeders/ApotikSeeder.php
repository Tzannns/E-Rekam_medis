<?php

namespace Database\Seeders;

use App\Models\Apotik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApotikSeeder extends Seeder
{
    public function run(): void
    {
        Apotik::factory(15)->create();
    }
}
