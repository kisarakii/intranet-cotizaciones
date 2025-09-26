<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        Usuario::updateOrCreate(
            ['email' => 'admin@intranet.test'],
            [
                'nombre'   => 'Admin',
                'apellido' => 'Principal',
                'edad'     => 30,
                'password' => Hash::make('Admin123!'), // contraseña demo
                'token'    => Str::random(40),
                'admin'    => true,
            ]
        );

        // Usuario menor de edad (para probar Observer + Mail en M6)
        Usuario::updateOrCreate(
            ['email' => 'menor@intranet.test'],
            [
                'nombre'   => 'Juan',
                'apellido' => 'Menor',
                'edad'     => 16,
                'password' => Hash::make('Menor123!'),
                'token'    => Str::random(40),
                'admin'    => false,
            ]
        );
    }
}
