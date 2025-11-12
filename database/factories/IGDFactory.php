<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IGD>
 */
class IGDFactory extends Factory
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
            'tanggal_masuk' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'tanggal_keluar' => $this->faker->optional()->dateTime(),
            'keluhan_utama' => $this->faker->sentence(),
            'triase_level' => $this->faker->randomElement(['Hijau', 'Kuning', 'Merah', 'Hitam']),
            'status' => $this->faker->randomElement(['Menunggu', 'Sedang Ditangani', 'Selesai', 'Dirujuk']),
            'catatan' => $this->faker->optional()->paragraph(),
        ];
    }
}
