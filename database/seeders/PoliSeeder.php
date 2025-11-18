<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $polis = [
            [
                'nama_poli' => 'Poli Umum',
                'kode_poli' => 'UMUM',
                'deskripsi' => 'Pelayanan kesehatan umum untuk berbagai keluhan ringan hingga sedang',
                'lokasi' => 'Lantai 1, Ruang A',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Gigi',
                'kode_poli' => 'GIGI',
                'deskripsi' => 'Pelayanan kesehatan gigi dan mulut',
                'lokasi' => 'Lantai 1, Ruang B',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Anak',
                'kode_poli' => 'ANAK',
                'deskripsi' => 'Pelayanan kesehatan khusus anak dan bayi',
                'lokasi' => 'Lantai 2, Ruang A',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Kandungan',
                'kode_poli' => 'OBGYN',
                'deskripsi' => 'Pelayanan kesehatan ibu hamil dan kandungan',
                'lokasi' => 'Lantai 2, Ruang B',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Jantung',
                'kode_poli' => 'JANTUNG',
                'deskripsi' => 'Pelayanan kesehatan jantung dan pembuluh darah',
                'lokasi' => 'Lantai 3, Ruang A',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Mata',
                'kode_poli' => 'MATA',
                'deskripsi' => 'Pelayanan kesehatan mata',
                'lokasi' => 'Lantai 3, Ruang B',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli THT',
                'kode_poli' => 'THT',
                'deskripsi' => 'Pelayanan kesehatan telinga, hidung, dan tenggorokan',
                'lokasi' => 'Lantai 3, Ruang C',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Kulit',
                'kode_poli' => 'KULIT',
                'deskripsi' => 'Pelayanan kesehatan kulit dan kelamin',
                'lokasi' => 'Lantai 4, Ruang A',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Penyakit Dalam',
                'kode_poli' => 'DALAM',
                'deskripsi' => 'Pelayanan kesehatan penyakit dalam',
                'lokasi' => 'Lantai 4, Ruang B',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Bedah',
                'kode_poli' => 'BEDAH',
                'deskripsi' => 'Pelayanan kesehatan bedah umum',
                'lokasi' => 'Lantai 4, Ruang C',
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
