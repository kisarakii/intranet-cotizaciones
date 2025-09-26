@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">{{ __('messages.users') }}</h4>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Nuevo usuario</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre completo</th>
                    <th>Email</th>
                    <th>Edad</th>
                    <th>Admin</th>
                    <th>Token</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($usuarios as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->nombre }} {{ $u->apellido }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->edad }}</td>
                        <td>
                            @if($u->admin)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td class="text-truncate" style="max-width: 160px;">{{ $u->token }}</td>
                        <td class="text-end">
                            <a href="{{ route('usuarios.show',$u->id) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                            <a href="{{ route('usuarios.edit',$u->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('usuarios.destroy',$u->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este usuario?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Sin usuarios</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>
@endsection
