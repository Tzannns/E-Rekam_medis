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
        // Run role and permission seeders first
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
        ]);

        // Create 4 default users
        // 1. Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@rekammedis.com'],
            ['name' => 'Administrator', 'password' => Hash::make('password')]
        );
        if (! $admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        // 2. Dokter
        $dokterUser = User::firstOrCreate(
            ['email' => 'dokter@rekammedis.com'],
            ['name' => 'Dr. Budi Santoso', 'password' => Hash::make('password')]
        );
        if (! $dokterUser->hasRole('Dokter')) {
            $dokterUser->assignRole('Dokter');
        }

        Dokter::firstOrCreate(
            ['user_id' => $dokterUser->id],
            ['nip' => 'DOK001', 'spesialisasi' => 'Dokter Umum', 'no_telp' => '081234567890']
        );

        // 3. Petugas
        $petugasUser = User::firstOrCreate(
            ['email' => 'petugas@rekammedis.com'],
            ['name' => 'Ikhsan', 'password' => Hash::make('password')]
        );
        if (! $petugasUser->hasRole('Petugas')) {
            $petugasUser->assignRole('Petugas');
        }

        // 4. Pasien
        $pasienUser = User::firstOrCreate(
            ['email' => 'pasien@rekammedis.com'],
            ['name' => 'Akhmad Fauzan', 'password' => Hash::make('password')]
        );
        if (! $pasienUser->hasRole('Pasien')) {
            $pasienUser->assignRole('Pasien');
        }

        Pasien::firstOrCreate(
            ['user_id' => $pasienUser->id],
            [
                'nik' => '3201010101900001',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Raya No. 123, Jakarta',
                'no_telp' => '081234567891',
            ]
        );

        // Now call other seeders after users are created
        $this->call([
            PoliSeeder::class,
            RekamMedisSeeder::class,
            IGDSeeder::class,
            RawatJalanSeeder::class,
            RawatInapSeeder::class,
            LaundrySeeder::class,
            GiziSeeder::class,
            KasirSeeder::class,
            StorageItemSeeder::class,
            ApotikSeeder::class,
            SupplierSeeder::class,
            ObatSeeder::class,
            StokObatSeeder::class,
            TransaksiApotikSeeder::class,
        ]);
    }
}
