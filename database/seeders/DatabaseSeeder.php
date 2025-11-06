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
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
        ]);

        // Create Admin User (idempotent)
        $admin = User::firstOrCreate(
            ['email' => 'admin@rekammedis.com'],
            ['name' => 'Administrator', 'password' => Hash::make('password')]
        );
        if (! $admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        // Create Dokter User (idempotent)
        $dokterUser = User::firstOrCreate(
            ['email' => 'dokter@rekammedis.com'],
            ['name' => 'Dr. Budi Santoso', 'password' => Hash::make('password')]
        );
        if (! $dokterUser->hasRole('Dokter')) {
            $dokterUser->assignRole('Dokter');
        }

        $dokter = Dokter::firstOrCreate(
            ['user_id' => $dokterUser->id],
            ['nip' => 'DOK001', 'spesialisasi' => 'Dokter Umum', 'no_telp' => '081234567890']
        );

        // Create Pasien User (idempotent)
        $pasienUser = User::firstOrCreate(
            ['email' => 'pasien@rekammedis.com'],
            ['name' => 'Ahmad Fauzi', 'password' => Hash::make('password')]
        );
        if (! $pasienUser->hasRole('Pasien')) {
            $pasienUser->assignRole('Pasien');
        }

        $pasien = Pasien::firstOrCreate(
            ['user_id' => $pasienUser->id],
            [
                'nik' => '3201010101900001',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Raya No. 123, Jakarta',
                'no_telp' => '081234567891',
            ]
        );

        // Optional: Create Petugas User (demo, idempotent)
        $petugasUser = User::firstOrCreate(
            ['email' => 'petugas@rekammedis.com'],
            ['name' => 'Petugas Pendaftaran', 'password' => Hash::make('password')]
        );
        if (! $petugasUser->hasRole('Petugas')) {
            $petugasUser->assignRole('Petugas');
        }
    }
}
