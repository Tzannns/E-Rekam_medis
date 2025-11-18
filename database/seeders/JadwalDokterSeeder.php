<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JadwalDokterSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus jadwal lama jika ada
        Jadwal::whereNull('pasien_id')->delete();

        $dokters = Dokter::with('poli')->get();

        // Generate jadwal untuk 30 hari ke depan
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(30);

        $jamPraktik = [
            ['jam_mulai' => '08:00', 'jam_selesai' => '10:00'],
            ['jam_mulai' => '10:00', 'jam_selesai' => '12:00'],
            ['jam_mulai' => '13:00', 'jam_selesai' => '15:00'],
            ['jam_mulai' => '15:00', 'jam_selesai' => '17:00'],
        ];

        $totalJadwal = 0;

        foreach ($dokters as $dokter) {
            if (!$dokter->poli_id) {
                continue;
            }

            // Setiap dokter praktik 3 hari dalam seminggu
            $hariPraktik = $this->getHariPraktik($dokter->id);

            $currentDate = $startDate->copy();
            while ($currentDate <= $endDate) {
                // Cek apakah hari ini adalah hari praktik dokter
                if (in_array($currentDate->dayOfWeek, $hariPraktik)) {
                    // Buat 2-3 slot jadwal per hari
                    $jumlahSlot = rand(2, 3);
                    $selectedSlots = array_rand($jamPraktik, $jumlahSlot);
                    
                    if (!is_array($selectedSlots)) {
                        $selectedSlots = [$selectedSlots];
                    }

                    foreach ($selectedSlots as $slotIndex) {
                        $slot = $jamPraktik[$slotIndex];
                        
                        Jadwal::create([
                            'dokter_id' => $dokter->id,
                            'poli_id' => $dokter->poli_id,
                            'pasien_id' => null,
                            'tanggal' => $currentDate->format('Y-m-d'),
                            'jam_mulai' => $slot['jam_mulai'],
                            'jam_selesai' => $slot['jam_selesai'],
                            'status' => 'tersedia',
                            'keterangan' => 'Jadwal praktik ' . $dokter->user->name . ' di ' . $dokter->poli->nama_poli,
                        ]);

                        $totalJadwal++;
                    }
                }

                $currentDate->addDay();
            }

            $this->command->info("✓ Jadwal untuk {$dokter->user->name} berhasil dibuat");
        }

        $this->command->info("\n✅ Seeder jadwal dokter selesai!");
        $this->command->info("Total Jadwal: {$totalJadwal}");
    }

    /**
     * Tentukan hari praktik dokter berdasarkan ID
     * Setiap dokter punya 3 hari praktik yang berbeda
     */
    private function getHariPraktik(int $dokterId): array
    {
        $allDays = [1, 2, 3, 4, 5, 6]; // Senin - Sabtu (0 = Minggu)
        
        // Gunakan modulo untuk distribusi merata
        $offset = $dokterId % 4;
        
        $patterns = [
            [1, 3, 5], // Senin, Rabu, Jumat
            [2, 4, 6], // Selasa, Kamis, Sabtu
            [1, 2, 4], // Senin, Selasa, Kamis
            [2, 3, 5], // Selasa, Rabu, Jumat
        ];

        return $patterns[$offset];
    }
}
