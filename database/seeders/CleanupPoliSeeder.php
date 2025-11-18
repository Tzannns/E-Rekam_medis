<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Database\Seeder;

class CleanupPoliSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🧹 Membersihkan data poli...');

        // Hapus poli yang tidak punya dokter
        $poliTanpaDokter = Poli::whereDoesntHave('dokter')->get();
        
        foreach ($poliTanpaDokter as $poli) {
            $this->command->warn("Menghapus poli tanpa dokter: {$poli->nama_poli} (ID: {$poli->id})");
            $poli->delete();
        }

        // Update status poli yang punya dokter menjadi aktif
        $poliDenganDokter = Poli::whereHas('dokter')->get();
        
        foreach ($poliDenganDokter as $poli) {
            $poli->update(['status' => 'aktif']);
            $this->command->info("✓ Poli {$poli->nama_poli} (ID: {$poli->id}) - Dokter: {$poli->dokter->count()}");
        }

        $this->command->info("\n✅ Cleanup selesai!");
        $this->command->info("Total Poli Aktif: " . Poli::where('status', 'aktif')->count());
        $this->command->info("Total Dokter: " . Dokter::whereNotNull('poli_id')->count());
    }
}
