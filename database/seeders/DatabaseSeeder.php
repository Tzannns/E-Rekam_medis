<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@rekammedis.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        // Create Dokter User
        $dokterUser = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'dokter@rekammedis.com',
            'password' => Hash::make('password'),
        ]);
        $dokterUser->assignRole('Dokter');

        $dokter = Dokter::create([
            'user_id' => $dokterUser->id,
            'nip' => 'DOK001',
            'spesialisasi' => 'Dokter Umum',
            'no_telp' => '081234567890',
        ]);

        // Create Pasien User
        $pasienUser = User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'pasien@rekammedis.com',
            'password' => Hash::make('password'),
        ]);
        $pasienUser->assignRole('Pasien');

        $pasien = Pasien::create([
            'user_id' => $pasienUser->id,
            'nik' => '3201010101900001',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Raya No. 123, Jakarta',
            'no_telp' => '081234567891',
        ]);
    }
}
