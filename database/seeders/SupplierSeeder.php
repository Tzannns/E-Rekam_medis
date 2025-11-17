<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        // Only create if no supplier exists
        if (Supplier::count() > 0) {
            return;
        }

        $suppliers = [
            [
                'kode_supplier' => 'SUP001',
                'nama_supplier' => 'PT Kimia Farma',
                'alamat' => 'Jl. Veteran No. 9, Jakarta Pusat',
                'telepon' => '021-3841031',
                'email' => 'info@kimiafarma.co.id',
                'contact_person' => 'Budi Hartono',
                'status' => 'Aktif',
            ],
            [
                'kode_supplier' => 'SUP002',
                'nama_supplier' => 'PT Kalbe Farma',
                'alamat' => 'Jl. Let. Jend. Suprapto, Jakarta Utara',
                'telepon' => '021-4220222',
                'email' => 'info@kalbe.co.id',
                'contact_person' => 'Siti Nurhaliza',
                'status' => 'Aktif',
            ],
            [
                'kode_supplier' => 'SUP003',
                'nama_supplier' => 'PT Sanbe Farma',
                'alamat' => 'Jl. Tamansari No. 80, Bandung',
                'telepon' => '022-2500456',
                'email' => 'info@sanbe.co.id',
                'contact_person' => 'Ahmad Yani',
                'status' => 'Aktif',
            ],
            [
                'kode_supplier' => 'SUP004',
                'nama_supplier' => 'PT Dexa Medica',
                'alamat' => 'Jl. Bambang Utoyo No. 138, Palembang',
                'telepon' => '0711-710710',
                'email' => 'info@dexa-medica.com',
                'contact_person' => 'Dewi Lestari',
                'status' => 'Aktif',
            ],
            [
                'kode_supplier' => 'SUP005',
                'nama_supplier' => 'PT Tempo Scan Pacific',
                'alamat' => 'Jl. Industri Raya Blok C3 No. 7, Jakarta',
                'telepon' => '021-4401088',
                'email' => 'info@tempo.co.id',
                'contact_person' => 'Rina Susanti',
                'status' => 'Aktif',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
