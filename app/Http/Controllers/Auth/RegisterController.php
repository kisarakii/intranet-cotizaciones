<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirección tras registrarse.
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validación del registro contra la tabla 'usuarios'.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre'   => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'edad'     => ['required', 'integer', 'min:0'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Crea el usuario en la tabla 'usuarios' con password hasheado y token aleatorio.
     */
    protected function create(array $data)
    {
        return Usuario::create([
            'nombre'   => $data['nombre'],
            'apellido' => $data['apellido'],
            'edad'     => (int) $data['edad'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'token'    => Str::random(40),
            'admin'    => false, // Por defecto, no admin
        ]);
    }
}
