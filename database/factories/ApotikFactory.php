<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apotik>
 */
class ApotikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 0;
        $counter++;

        $namaApotik = [
            'Apotik Sehat Sejahtera',
            'Apotik Utama Farmasi',
            'Apotik Jaya Sentosa',
            'Apotik Maju Makmur',
            'Apotik Permata Medis',
            'Apotik Sinar Kesehatan',
            'Apotik Putra Medika',
            'Apotik Bintang Farmasi',
            'Apotik Griya Obat',
            'Apotik Harmoni Sehat',
            'Apotik Kesehatan Bersama',
            'Apotik Medis Teladan',
            'Apotik Nama Baik',
            'Apotik Oasis Farmasi',
            'Apotik Perdana Kesehatan',
        ];

        $lokasi = [
            'Jl. Merdeka No. 123',
            'Jl. Gatot Subroto No. 45',
            'Jl. Ahmad Yani No. 67',
            'Jl. Diponegoro No. 89',
            'Jl. Sudirman No. 101',
            'Jl. Imam Bonjol No. 112',
            'Jl. Sisingamangaraja No. 134',
            'Jl. Panglima Polim No. 156',
            'Jl. Kramat Raya No. 178',
            'Jl. Benda No. 190',
        ];

        return [
            'kode_apotik' => 'APT'.str_pad($counter, 4, '0', STR_PAD_LEFT),
            'nama_apotik' => $this->faker->randomElement($namaApotik),
            'lokasi' => $this->faker->randomElement($lokasi),
            'telepon' => '08'.$this->faker->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => $this->faker->randomElement(['Aktif', 'Nonaktif']),
        ];
    }
}
