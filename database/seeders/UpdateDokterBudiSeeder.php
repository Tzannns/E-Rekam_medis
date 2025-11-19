<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UpdateDokterBudiSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔄 Update Dokter Budi Santoso...');

        // Cari poli umum
        $poliUmum = Poli::where('kode_poli', 'UMUM')->first();

        if (! $poliUmum) {
            $this->command->error('Poli Umum tidak ditemukan!');

            return;
        }

        // Cari atau buat user untuk Dr. Budi Santoso
        $user = User::where('email', 'dokter@rekammedis.com')->first();

        if (! $user) {
            $user = User::create([
                'name' => 'Dr. Budi Santoso',
                'email' => 'dokter@rekammedis.com',
                'password' => Hash::make('password'),
            ]);
            $this->command->info('✓ User Dr. Budi Santoso dibuat');
        } else {
            $user->update(['name' => 'Dr. Budi Santoso']);
            $this->command->info('✓ User Dr. Budi Santoso diupdate');
        }

        // Assign role Dokter
        if (! $user->hasRole('Dokter')) {
            $user->assignRole('Dokter');
            $this->command->info('✓ Role Dokter assigned');
        }

        // Update atau buat dokter dengan NIP DOK001
        $dokter = Dokter::where('nip', 'DOK001')->first();

        if ($dokter) {
            $dokter->update([
                'user_id' => $user->id,
                'poli_id' => $poliUmum->id,
                'spesialisasi' => 'Dokter Umum',
                'no_telp' => '081234567890',
            ]);
            $this->command->info('✓ Dokter DOK001 diupdate');
        } else {
            $dokter = Dokter::create([
                'user_id' => $user->id,
                'nip' => 'DOK001',
                'poli_id' => $poliUmum->id,
                'spesialisasi' => 'Dokter Umum',
                'no_telp' => '081234567890',
            ]);
            $this->command->info('✓ Dokter DOK001 dibuat');
        }

        // Hapus dokter lama di poli umum jika ada (selain DOK001)
        $dokterLama = Dokter::where('poli_id', $poliUmum->id)
            ->where('nip', '!=', 'DOK001')
            ->get();

        foreach ($dokterLama as $old) {
            $this->command->warn("Menghapus dokter lama: {$old->user->name} (NIP: {$old->nip})");

            // Update jadwal ke dokter baru
            \DB::table('jadwal')
                ->where('dokter_id', $old->id)
                ->update(['dokter_id' => $dokter->id]);

            // Hapus dokter lama
            $old->delete();
        }

        $this->command->info("\n✅ Update selesai!");
        $this->command->info('Email: dokter@rekammedis.com');
        $this->command->info('Password: password');
        $this->command->info('NIP: DOK001');
    }
}
