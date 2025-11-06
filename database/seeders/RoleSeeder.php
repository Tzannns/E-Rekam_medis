<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Dokter']);
        Role::firstOrCreate(['name' => 'Pasien']);
        Role::firstOrCreate(['name' => 'Petugas']);
    }
}
