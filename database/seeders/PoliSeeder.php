<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            [
                'nama_poli' => 'Poli Umum',
                'kode_poli' => 'POL-UMUM',
                'deskripsi' => 'Poli untuk penanganan penyakit umum',
                'lokasi' => 'Lantai 1',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Anak',
                'kode_poli' => 'POL-ANAK',
                'deskripsi' => 'Poli untuk penanganan penyakit anak',
                'lokasi' => 'Lantai 1',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Kandungan',
                'kode_poli' => 'POL-KAND',
                'deskripsi' => 'Poli untuk penanganan kesehatan kandungan dan kebidanan',
                'lokasi' => 'Lantai 2',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Jantung',
                'kode_poli' => 'POL-JANT',
                'deskripsi' => 'Poli untuk penanganan penyakit jantung',
                'lokasi' => 'Lantai 2',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Saraf',
                'kode_poli' => 'POL-SARAF',
                'deskripsi' => 'Poli untuk penanganan penyakit saraf',
                'lokasi' => 'Lantai 3',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Mata',
                'kode_poli' => 'POL-MATA',
                'deskripsi' => 'Poli untuk penanganan penyakit mata',
                'lokasi' => 'Lantai 3',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli THT',
                'kode_poli' => 'POL-THT',
                'deskripsi' => 'Poli untuk penanganan penyakit Telinga, Hidung, dan Tenggorokan',
                'lokasi' => 'Lantai 3',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Kulit',
                'kode_poli' => 'POL-KULIT',
                'deskripsi' => 'Poli untuk penanganan penyakit kulit',
                'lokasi' => 'Lantai 4',
                'status' => 'aktif',
            ],
        ];

        foreach ($polis as $poli) {
            Poli::firstOrCreate(
                ['kode_poli' => $poli['kode_poli']],
                $poli
            );
        }
    }
}
