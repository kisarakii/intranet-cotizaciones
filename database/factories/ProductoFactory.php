<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        // SKU legible y único
        $sku = 'SKU-' . strtoupper(Str::random(8));

        return [
            'sku'             => $sku,
            'nombre'          => ucfirst($this->faker->unique()->words(3, true)),
            'precio_unitario' => $this->faker->randomFloat(2, 5, 500), // 5.00 - 500.00
        ];
    }
}
