<?php

namespace Database\Factories;

use App\Models\Poli;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poli>
 */
class PoliFactory extends Factory
{
    protected $model = Poli::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaPoli = [
            'Poli Umum',
            'Poli Anak',
            'Poli Kandungan',
            'Poli Jantung',
            'Poli Saraf',
            'Poli Mata',
            'Poli THT',
            'Poli Kulit',
            'Poli Bedah',
            'Poli Ortopedi',
        ];

        $kodePoli = [
            'POL-UMUM',
            'POL-ANAK',
            'POL-KAND',
            'POL-JANT',
            'POL-SARAF',
            'POL-MATA',
            'POL-THT',
            'POL-KULIT',
            'POL-BEDAH',
            'POL-ORTO',
        ];

        $lokasi = [
            'Lantai 1',
            'Lantai 2',
            'Lantai 3',
            'Lantai 4',
        ];

        $index = $this->faker->numberBetween(0, count($namaPoli) - 1);
        $nama = $namaPoli[$index];
        $kode = $kodePoli[$index];

        return [
            'nama_poli' => $nama,
            'kode_poli' => $kode,
            'deskripsi' => $this->faker->optional()->sentence(10),
            'lokasi' => $this->faker->randomElement($lokasi),
            'status' => $this->faker->randomElement(['aktif', 'tidak_aktif']),
        ];
    }
}
