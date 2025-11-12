<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dokter>
 */
class DokterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nip' => $this->faker->unique()->numerify('################'),
            'spesialisasi' => $this->faker->randomElement(['Umum', 'Anak', 'Penyakit Dalam', 'Kandungan', 'Bedah']),
            'no_telp' => $this->faker->phoneNumber(),
        ];
    }
}
