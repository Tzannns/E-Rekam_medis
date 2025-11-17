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

            // Rawat Jalan
            'rawat-jalan.view',
            'rawat-jalan.create',
            'rawat-jalan.edit',
            'rawat-jalan.delete',

            // Rawat Inap
            'rawat-inap.view',
            'rawat-inap.create',
            'rawat-inap.edit',
            'rawat-inap.delete',

            // Kasir
            'kasir.view',
            'kasir.create',
            'kasir.edit',
            'kasir.delete',
            'storage.view',
            'apotik.view',
            'laboratorium.view',
            'radiologi.view',
            'manajemen.view',
            'gizi.view',
            'gizi.create',
            'gizi.edit',
            'gizi.delete',
            'laundry.view',
            'laundry.create',
            'laundry.edit',
            'laundry.delete',

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
                'rawat-jalan.create',
                'rawat-jalan.edit',
                'rawat-jalan.delete',
                'rawat-inap.view',
                'rawat-inap.create',
                'rawat-inap.edit',
                'rawat-inap.delete',
                'kasir.view',
                'kasir.create',
                'kasir.edit',
                'kasir.delete',
                'storage.view',
                'apotik.view',
                'laboratorium.view',
                'radiologi.view',
                'gizi.view',
                'gizi.create',
                'gizi.edit',
                'gizi.delete',
                'laundry.view',
                'laundry.create',
                'laundry.edit',
                'laundry.delete',
                // tidak termasuk master data: users.*, dokter.*, pasien.*, manajemen.*
            ]);
        }

        $dokterRole = Role::where('name', 'Dokter')->first();
        if ($dokterRole) {
            $dokterRole->syncPermissions([
                'rekam-medis.view',
                'rekam-medis.create',
                'rekam-medis.update',
                'igd.view',
                'igd.edit',
                'rawat-jalan.view',
                'rawat-jalan.edit',
                'rawat-inap.view',
                'rawat-inap.edit',
                'laboratorium.view',
                'radiologi.view',
                'pasien.view',
            ]);
        }
    }
}
