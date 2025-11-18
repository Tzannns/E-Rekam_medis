<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Poli;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokter = Dokter::first();
        $polis = Poli::where('status', 'aktif')->get();

        if (! $dokter || $polis->isEmpty()) {
            return;
        }

        $startDate = Carbon::today();
        $days = 10;
        $sessions = [
            ['08:00:00', '10:00:00'],
            ['10:00:00', '12:00:00'],
            ['13:00:00', '15:00:00'],
        ];

        for ($d = 0; $d < $days; $d++) {
            $date = (clone $startDate)->addDays($d);
            foreach ($polis as $poli) {
                foreach ($sessions as $idx => [$mulai, $selesai]) {
                    Jadwal::firstOrCreate(
                        [
                            'dokter_id' => $dokter->id,
                            'poli_id' => $poli->id,
                            'tanggal' => $date->toDateString(),
                            'jam_mulai' => $mulai,
                            'jam_selesai' => $selesai,
                        ],
                        [
                            'status' => 'tersedia',
                            'keterangan' => 'Sesi '.($idx + 1).' - '.$poli->nama_poli,
                        ]
                    );
                }
            }
        }
    }
}