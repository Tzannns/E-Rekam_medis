<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StorageItem>
 */
class StorageItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stokAwal = $this->faker->numberBetween(50, 500);
        $stokSaatIni = $this->faker->numberBetween(10, $stokAwal);
        $hargaSatuan = $this->faker->numberBetween(1000, 50000);

        return [
            'kode_barang' => 'BRG'.$this->faker->unique()->numerify('######'),
            'nama_barang' => $this->faker->words(3, true),
            'kategori' => $this->faker->randomElement(['Obat', 'Alat Medis', 'Consumable', 'Lainnya']),
            'deskripsi' => $this->faker->sentence(),
            'stok_awal' => $stokAwal,
            'stok_saat_ini' => $stokSaatIni,
            'stok_minimal' => $this->faker->numberBetween(5, 20),
            'satuan' => $this->faker->randomElement(['Pcs', 'Box', 'Botol', 'Tube', 'Strip', 'Dus']),
            'harga_satuan' => $hargaSatuan,
            'total_nilai' => $stokSaatIni * $hargaSatuan,
            'lokasi' => $this->faker->randomElement(['Rak A', 'Rak B', 'Rak C', 'Kulkas 1', 'Kulkas 2']),
            'tanggal_masuk' => $this->faker->dateTimeBetween('-6 months'),
            'tanggal_kadaluarsa' => $this->faker->dateTimeBetween('now', '+2 years'),
            'status' => $this->faker->randomElement(['Aktif', 'Nonaktif']),
            'supplier' => $this->faker->company(),
            'nomor_batch' => 'BATCH'.$this->faker->numerify('######'),
        ];
    }
}
