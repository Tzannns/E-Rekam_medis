<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
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
            'nik' => $this->faker->unique()->numerify('################'),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-60 years'),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'alamat' => $this->faker->address(),
            'no_telp' => $this->faker->optional()->phoneNumber(),
        ];
    }
}
