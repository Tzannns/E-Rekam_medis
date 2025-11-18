<?php

namespace App\Console\Commands;

use App\Models\Dokter;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateJadwalDokter extends Command
{
    protected $signature = 'jadwal:generate {days=30 : Jumlah hari ke depan}';

    protected $description = 'Generate jadwal praktik dokter untuk beberapa hari ke depan';

    public function handle()
    {
        $days = (int) $this->argument('days');
        
        $this->info("🏥 Generating jadwal dokter untuk {$days} hari ke depan...\n");

        // Hapus jadwal lama yang belum terisi
        $deletedCount = Jadwal::whereNull('pasien_id')
            ->where('tanggal', '>=', Carbon::today())
            ->delete();
        
        if ($deletedCount > 0) {
            $this->warn("🗑️  Menghapus {$deletedCount} jadwal lama yang belum terisi\n");
        }

        $dokters = Dokter::with('poli')->get();
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays($days);

        $jamPraktik = [
            ['jam_mulai' => '08:00', 'jam_selesai' => '10:00'],
            ['jam_mulai' => '10:00', 'jam_selesai' => '12:00'],
            ['jam_mulai' => '13:00', 'jam_selesai' => '15:00'],
            ['jam_mulai' => '15:00', 'jam_selesai' => '17:00'],
        ];

        $totalJadwal = 0;
        $progressBar = $this->output->createProgressBar($dokters->count());
        $progressBar->start();

        foreach ($dokters as $dokter) {
            if (!$dokter->poli_id) {
                $progressBar->advance();
                continue;
            }

            $hariPraktik = $this->getHariPraktik($dokter->id);
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                if (in_array($currentDate->dayOfWeek, $hariPraktik)) {
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

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);
        $this->info("✅ Berhasil generate {$totalJadwal} jadwal untuk {$dokters->count()} dokter");
        $this->info("📅 Periode: " . $startDate->format('d M Y') . " - " . $endDate->format('d M Y'));

        return Command::SUCCESS;
    }

    private function getHariPraktik(int $dokterId): array
    {
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
