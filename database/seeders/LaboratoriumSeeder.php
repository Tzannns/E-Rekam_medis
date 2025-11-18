<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Laboratorium;
use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LaboratoriumSeeder extends Seeder
{
    public function run(): void
    {
        if (Laboratorium::query()->exists()) {
            return;
        }

        $pasien = Pasien::first();
        $dokter = Dokter::first();

        if (! $pasien || ! $dokter) {
            return;
        }

        $jenis = [
            'Hematologi Lengkap',
            'Kimia Darah',
            'Urinalisa',
            'Feses Lengkap',
            'Gula Darah',
            'Kolesterol Total',
        ];

        $statusList = ['Diajukan', 'Diproses', 'Selesai'];

        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $tanggalPeriksa = Carbon::now()->subDays(rand(0, 20))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $status = $statusList[array_rand($statusList)];
            $rows[] = [
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokter->id,
                'jenis_pemeriksaan' => $jenis[array_rand($jenis)],
                'hasil' => rand(0, 1) ? 'Nilai dalam batas normal' : 'Perlu evaluasi lebih lanjut',
                'nilai_rujukan' => 'Tergantung pemeriksaan',
                'satuan' => 'mg/dL',
                'tanggal_periksa' => $tanggalPeriksa,
                'status' => $status,
                'catatan' => rand(0, 1) ? 'Puasa sebelum pemeriksaan' : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Laboratorium::query()->insert($rows);
    }
}
