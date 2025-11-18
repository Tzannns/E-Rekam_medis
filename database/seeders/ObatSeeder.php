<?php

namespace Database\Seeders;

use App\Models\Apotik;
use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        // Only create if no obat exists
        if (Obat::count() > 0) {
            return;
        }

        $apotik = Apotik::first();
        $suppliers = Supplier::all();

        if (! $apotik || $suppliers->isEmpty()) {
            $this->command->warn('Pastikan Apotik dan Supplier sudah di-seed terlebih dahulu');

            return;
        }

        $obats = [
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT001',
                'nama_obat' => 'Paracetamol 500mg',
                'kategori' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Obat penurun panas dan pereda nyeri',
                'harga_beli' => 2000,
                'harga_jual' => 3000,
                'stok' => 100,
                'stok_minimum' => 20,
                'tanggal_kadaluarsa' => now()->addYears(2),
                'no_batch' => 'BATCH001',
                'status' => 'Tersedia',
            ],
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT002',
                'nama_obat' => 'Amoxicillin 500mg',
                'kategori' => 'Kapsul',
                'satuan' => 'Strip',
                'deskripsi' => 'Antibiotik untuk infeksi bakteri',
                'harga_beli' => 5000,
                'harga_jual' => 7500,
                'stok' => 80,
                'stok_minimum' => 15,
                'tanggal_kadaluarsa' => now()->addYears(2),
                'no_batch' => 'BATCH002',
                'status' => 'Tersedia',
            ],
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT003',
                'nama_obat' => 'OBH Combi Sirup',
                'kategori' => 'Sirup',
                'satuan' => 'Botol',
                'deskripsi' => 'Obat batuk berdahak',
                'harga_beli' => 12000,
                'harga_jual' => 18000,
                'stok' => 50,
                'stok_minimum' => 10,
                'tanggal_kadaluarsa' => now()->addYears(1)->addMonths(6),
                'no_batch' => 'BATCH003',
                'status' => 'Tersedia',
            ],
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT004',
                'nama_obat' => 'Antasida DOEN',
                'kategori' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Obat maag dan gangguan pencernaan',
                'harga_beli' => 3000,
                'harga_jual' => 4500,
                'stok' => 60,
                'stok_minimum' => 15,
                'tanggal_kadaluarsa' => now()->addYears(2),
                'no_batch' => 'BATCH004',
                'status' => 'Tersedia',
            ],
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT005',
                'nama_obat' => 'Betadine Solution 15ml',
                'kategori' => 'Cairan',
                'satuan' => 'Botol',
                'deskripsi' => 'Antiseptik untuk luka',
                'harga_beli' => 15000,
                'harga_jual' => 22000,
                'stok' => 40,
                'stok_minimum' => 10,
                'tanggal_kadaluarsa' => now()->addYears(3),
                'no_batch' => 'BATCH005',
                'status' => 'Tersedia',
            ],
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT006',
                'nama_obat' => 'Salep 88',
                'kategori' => 'Salep',
                'satuan' => 'Tube',
                'deskripsi' => 'Obat gatal dan iritasi kulit',
                'harga_beli' => 8000,
                'harga_jual' => 12000,
                'stok' => 35,
                'stok_minimum' => 10,
                'tanggal_kadaluarsa' => now()->addYears(2),
                'no_batch' => 'BATCH006',
                'status' => 'Tersedia',
            ],
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT007',
                'nama_obat' => 'Vitamin C 1000mg',
                'kategori' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Suplemen vitamin C',
                'harga_beli' => 10000,
                'harga_jual' => 15000,
                'stok' => 70,
                'stok_minimum' => 20,
                'tanggal_kadaluarsa' => now()->addYears(2),
                'no_batch' => 'BATCH007',
                'status' => 'Tersedia',
            ],
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT008',
                'nama_obat' => 'Ibuprofen 400mg',
                'kategori' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Anti inflamasi dan pereda nyeri',
                'harga_beli' => 4000,
                'harga_jual' => 6000,
                'stok' => 90,
                'stok_minimum' => 20,
                'tanggal_kadaluarsa' => now()->addYears(2),
                'no_batch' => 'BATCH008',
                'status' => 'Tersedia',
            ],
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT009',
                'nama_obat' => 'Cetirizine 10mg',
                'kategori' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Obat alergi',
                'harga_beli' => 3500,
                'harga_jual' => 5500,
                'stok' => 55,
                'stok_minimum' => 15,
                'tanggal_kadaluarsa' => now()->addYears(2),
                'no_batch' => 'BATCH009',
                'status' => 'Tersedia',
            ],
            [
                'apotik_id' => $apotik->id,
                'supplier_id' => $suppliers->random()->id,
                'kode_obat' => 'OBT010',
                'nama_obat' => 'Promag Tablet',
                'kategori' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Obat maag',
                'harga_beli' => 2500,
                'harga_jual' => 4000,
                'stok' => 8,
                'stok_minimum' => 10,
                'tanggal_kadaluarsa' => now()->addYears(2),
                'no_batch' => 'BATCH010',
                'status' => 'Tersedia',
            ],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
