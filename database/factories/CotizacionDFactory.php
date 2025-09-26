<?php

namespace Database\Factories;

use App\Models\CotizacionD;
use App\Models\CotizacionC;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\CotizacionD>
 */
class CotizacionDFactory extends Factory
{
    protected $model = CotizacionD::class;

    public function definition(): array
    {
        // Creamos/obtenemos un producto para amarrar SKU y precio
        $producto = Producto::factory()->create();

        return [
            'cotizacion_id'   => CotizacionC::factory(),
            'producto_sku'    => $producto->sku,
            'cantidad'        => $this->faker->numberBetween(1, 5),
            'precio_unitario' => $producto->precio_unitario, // coherente con el producto
            'fecha_registro'  => now(),
        ];
    }
}
