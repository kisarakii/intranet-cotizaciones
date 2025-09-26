<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // Solo autenticados + policy/gate admin (lo aplicaremos en rutas)
        $this->middleware('auth');
        $this->authorizeResource(Usuario::class, 'usuario');
    }

    public function index()
    {
        $usuarios = Usuario::orderBy('id','desc')->paginate(10);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(StoreUsuarioRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['token'] = Str::random(40);              // token autogenerado
        $data['admin'] = isset($data['admin']) ? (bool)$data['admin'] : false;

        $usuario = Usuario::create($data);

        return redirect()->route('usuarios.index')
            ->with('status','Usuario creado correctamente.');
    }

    public function show(Usuario $usuario)
    {
        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        $data = $request->validated();

        // Si viene password, la actualizamos, si no, se mantiene
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // token es de solo lectura: no lo tocamos
        unset($data['token']);

        $data['admin'] = isset($data['admin']) ? (bool)$data['admin'] : false;

        $usuario->update($data);

        return redirect()->route('usuarios.index')
            ->with('status','Usuario actualizado.');
    }

    public function destroy(Usuario $usuario)
    {
        // Evitar que un admin se borre a sí mismo por accidente (buena práctica básica)
        if (auth()->id() === $usuario->id) {
            return back()->with('status','No puedes eliminar tu propio usuario.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('status','Usuario eliminado.');
    }
}
