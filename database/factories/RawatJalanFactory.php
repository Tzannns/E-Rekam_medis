<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RawatJalan>
 */
class RawatJalanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pasien_id' => \App\Models\Pasien::factory(),
            'dokter_id' => \App\Models\Dokter::factory(),
            'poli_id' => \App\Models\Poli::factory(),
            'tanggal_kunjungan' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'keluhan' => $this->faker->sentence(),
            'diagnosa' => $this->faker->optional()->sentence(),
            'tindakan' => $this->faker->optional()->sentence(),
            'resep_obat' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(['Menunggu', 'Sedang Diperiksa', 'Selesai', 'Batal']),
            'catatan' => $this->faker->optional()->paragraph(),
        ];
    }
}
