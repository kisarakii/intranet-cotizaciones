@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Editar usuario #{{ $usuario->id }}</h4>

    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}" class="card card-body">
        @csrf @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                       class="form-control @error('nombre') is-invalid @enderror" required>
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Apellido</label>
                <input name="apellido" value="{{ old('apellido', $usuario->apellido) }}"
                       class="form-control @error('apellido') is-invalid @enderror" required>
                @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Edad</label>
                <input type="number" min="0" name="edad" value="{{ old('edad', $usuario->edad) }}"
                       class="form-control @error('edad') is-invalid @enderror" required>
                @error('edad') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-8">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                       class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Nueva contraseña (opcional)</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror" placeholder="Dejar vacío para no cambiar">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirmar nueva contraseña (si aplica)</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Solo si cambias contraseña">
            </div>

            <div class="col-md-4">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="admin" value="1" id="adminCheck"
                        {{ old('admin', $usuario->admin) ? 'checked' : '' }}>
                    <label class="form-check-label" for="adminCheck">Es administrador</label>
                </div>
            </div>

            <div class="col-md-8">
                <label class="form-label">Token</label>
                <input class="form-control" value="{{ $usuario->token }}" readonly>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Volver</a>
            <button class="btn btn-primary">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
