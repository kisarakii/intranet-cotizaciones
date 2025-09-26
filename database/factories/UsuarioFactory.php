<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        $nombre   = $this->faker->firstName();
        $apellido = $this->faker->lastName();

        return [
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'edad'     => $this->faker->numberBetween(16, 65),
            'email'    => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Contraseña por defecto para pruebas
            'token'    => Str::random(40),
            'admin'    => $this->faker->boolean(10), // 10% admins
        ];
    }
}
