<?php

namespace Database\Factories;

use App\Models\CotizacionC;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\CotizacionC>
 */
class CotizacionCFactory extends Factory
{
    protected $model = CotizacionC::class;

    public function definition(): array
    {
        return [
            // Crea o toma un usuario para la FK
            'usuario_id'     => Usuario::factory(),
            'fecha_emision'  => $this->faker->dateTimeBetween('-30 days', 'now'),
            'total_bruto'    => 0, // se recalcula luego según detalle
            'fecha_registro' => now(),
        ];
    }
}
