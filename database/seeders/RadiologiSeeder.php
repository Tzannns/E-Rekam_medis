<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Radiologi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RadiologiSeeder extends Seeder
{
    public function run(): void
    {
        if (Radiologi::query()->exists()) {
            return;
        }

        $pasien = Pasien::first();
        $dokter = Dokter::first();

        if (! $pasien || ! $dokter) {
            return;
        }

        $jenis = [
            'Rontgen Dada',
            'CT Scan Kepala',
            'MRI Lutut',
            'USG Abdomen',
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
                'hasil' => rand(0, 1) ? 'Tidak ditemukan kelainan' : 'Temuan: perlu evaluasi lanjutan',
                'tanggal_periksa' => $tanggalPeriksa,
                'status' => $status,
                'catatan' => rand(0, 1) ? 'Lampirkan hasil cetak' : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Radiologi::query()->insert($rows);
    }
}
