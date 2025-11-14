<?php

namespace Database\Factories;

use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RawatInap>
 */
class RawatInapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pasien_id' => Pasien::factory(),
            'dokter_id' => Dokter::factory(),
            'tanggal_masuk' => $this->faker->date('Y-m-d', '-30 days'),
            'tanggal_keluar' => $this->faker->optional()->date('Y-m-d'),
            'ruang' => $this->faker->randomElement(['ICU', 'Bersalin', 'Anak', 'Bedah', 'Penyakit Dalam']),
            'no_tempat_tidur' => $this->faker->numerify('###'),
            'diagnosa' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['Menunggu', 'Sedang Dirawat', 'Selesai', 'Dirujuk']),
            'catatan' => $this->faker->optional()->paragraph(),
        ];
    }
}
