<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePerfilRequest;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function __construct()
    {
        // Solo usuarios autenticados
        $this->middleware('auth');
    }

    /**
     * Muestra el formulario con los datos del usuario autenticado.
     */
    public function edit()
    {
        $usuario = auth()->user(); // instancia de App\Models\Usuario
        return view('perfil.edit', compact('usuario'));
    }

    /**
     * Actualiza el perfil del usuario autenticado.
     */
    public function update(UpdatePerfilRequest $request)
    {
        $usuario = auth()->user();

        $data = $request->only(['nombre', 'apellido', 'edad', 'email']);

        // Si se envió password (opcional), la hasheamos
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $usuario->update($data);

        return redirect()
            ->route('perfil.edit')
            ->with('status', 'Tu perfil se actualizó correctamente.');
    }
}
