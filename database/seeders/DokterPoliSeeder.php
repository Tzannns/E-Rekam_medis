<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DokterPoliSeeder extends Seeder
{
    public function run(): void
    {
        // Data dokter per poli - 1 dokter per poli
        $dokterData = [
            'UMUM' => ['name' => 'Dr. Budi Santoso', 'nip' => 'DOK001', 'spesialisasi' => 'Dokter Umum'],
            'GIGI' => ['name' => 'drg. Rina Wijaya, Sp.KG', 'nip' => '198604102010012001', 'spesialisasi' => 'Spesialis Konservasi Gigi'],
            'ANAK' => ['name' => 'Dr. Dewi Lestari, Sp.A', 'nip' => '198506152010012001', 'spesialisasi' => 'Spesialis Anak'],
            'OBGYN' => ['name' => 'Dr. Ani Yudhoyono, Sp.OG', 'nip' => '198407102010012001', 'spesialisasi' => 'Spesialis Kandungan'],
            'JANTUNG' => ['name' => 'Dr. Bambang Sutrisno, Sp.JP', 'nip' => '198305052010011001', 'spesialisasi' => 'Spesialis Jantung'],
            'MATA' => ['name' => 'Dr. Linda Kusuma, Sp.M', 'nip' => '198606202010012001', 'spesialisasi' => 'Spesialis Mata'],
            'THT' => ['name' => 'Dr. Ratna Sari, Sp.THT', 'nip' => '198505102010012001', 'spesialisasi' => 'Spesialis THT'],
            'KULIT' => ['name' => 'Dr. Fitri Handayani, Sp.KK', 'nip' => '198604152010012001', 'spesialisasi' => 'Spesialis Kulit dan Kelamin'],
            'DALAM' => ['name' => 'Dr. Hadi Wijaya, Sp.PD', 'nip' => '198403052010011001', 'spesialisasi' => 'Spesialis Penyakit Dalam'],
            'BEDAH' => ['name' => 'Dr. Joko Widodo, Sp.B', 'nip' => '198302102010011001', 'spesialisasi' => 'Spesialis Bedah Umum'],
        ];

        foreach ($dokterData as $kodePoli => $dokterInfo) {
            $poli = Poli::where('kode_poli', $kodePoli)->first();
            
            if (!$poli) {
                $this->command->warn("Poli dengan kode {$kodePoli} tidak ditemukan. Skip.");
                continue;
            }

            // Cek apakah user sudah ada berdasarkan NIP
            $email = strtolower(str_replace([' ', '.', ','], '', $dokterInfo['name'])) . '@hospital.com';
            
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $dokterInfo['name'],
                    'password' => Hash::make('password123'),
                ]
            );

            // Assign role Dokter jika belum punya
            if (!$user->hasRole('Dokter')) {
                $user->assignRole('Dokter');
            }

            // Buat atau update dokter
            $dokter = Dokter::firstOrCreate(
                ['nip' => $dokterInfo['nip']],
                [
                    'user_id' => $user->id,
                    'poli_id' => $poli->id,
                    'spesialisasi' => $dokterInfo['spesialisasi'],
                    'no_telp' => '08' . rand(1000000000, 9999999999),
                ]
            );

            // Update poli_id jika dokter sudah ada tapi belum punya poli
            if (!$dokter->poli_id) {
                $dokter->update(['poli_id' => $poli->id]);
            }

            $this->command->info("✓ Dokter {$dokterInfo['name']} di {$poli->nama_poli} berhasil dibuat/diupdate");
        }

        $this->command->info("\n✅ Seeder dokter per poli selesai!");
        $this->command->info("Total Poli: " . Poli::count());
        $this->command->info("Total Dokter: " . Dokter::count());
    }
}
