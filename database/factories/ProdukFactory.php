<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kd_produk' => $this->faker->uuid(),
            'nm_produk' => $this->faker->word,
            'deskripsi' => $this->faker->sentence,
            'stok' => $this->faker->numberBetween(0, 100),
            'harga_beli' => $this->faker->randomFloat(2, 1, 100),
            'harga_jual' => $this->faker->randomFloat(2, 100, 200),
            'kategori_id' => 1,
            'satuan_id' => 1,
            'user_id' => 1,
        ];
    }
}