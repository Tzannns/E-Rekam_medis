<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Pendaftaran
            'pendaftaran.view',
            'pendaftaran.create',
            'pendaftaran.update',
            'pendaftaran.delete',

            // Rekam Medis
            'rekam-medis.view',
            'rekam-medis.create',
            'rekam-medis.update',
            'rekam-medis.delete',

            // Pasien
            'pasien.view',
            'pasien.create',
            'pasien.update',
            'pasien.delete',

            // Dokter
            'dokter.view',
            'dokter.create',
            'dokter.update',
            'dokter.delete',

            // IGD
            'igd.view',
            'igd.create',
            'igd.edit',
            'igd.delete',

            // Modul lain (hanya view untuk contoh)
            'rawat-jalan.view',
            'rawat-inap.view',
            'kasir.view',
            'storage.view',
            'apotik.view',
            'laboratorium.view',
            'radiologi.view',
            'manajemen.view',
            'gizi.view',
            'laundry.view',

            // Users management
            'users.view',
            'users.update',
            'users.delete',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->syncPermissions(Permission::all());
        }

        $petugasRole = Role::where('name', 'Petugas')->first();
        if ($petugasRole) {
            $petugasRole->syncPermissions([
                'pendaftaran.view',
                'pendaftaran.create',
                'rekam-medis.view',
                'igd.view',
                'igd.create',
                'igd.edit',
                'igd.delete',
                'rawat-jalan.view',
                'rawat-inap.view',
                'kasir.view',
                'storage.view',
                'apotik.view',
                'laboratorium.view',
                'radiologi.view',
                'gizi.view',
                'laundry.view',
                // tidak termasuk master data: users.*, dokter.*, pasien.*, manajemen.*
            ]);
        }
    }
}
