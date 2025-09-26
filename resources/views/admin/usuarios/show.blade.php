@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">{{ __('messages.user_title') }} #{{ $usuario->id }}</h4>
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">{{ __('messages.back') }}</a>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">{{ __('messages.first_name') }}</dt>
                <dd class="col-sm-9">{{ $usuario->nombre }}</dd>

                <dt class="col-sm-3">{{ __('messages.last_name') }}</dt>
                <dd class="col-sm-9">{{ $usuario->apellido }}</dd>

                <dt class="col-sm-3">{{ __('messages.email') }}</dt>
                <dd class="col-sm-9">{{ $usuario->email }}</dd>

                <dt class="col-sm-3">{{ __('messages.age') }}</dt>
                <dd class="col-sm-9">{{ $usuario->edad }}</dd>

                <dt class="col-sm-3">{{ __('messages.is_admin') }}</dt>
                <dd class="col-sm-9">{{ $usuario->admin ? __('messages.yes') : __('messages.no') }}</dd>

                <dt class="col-sm-3">{{ __('messages.token') }}</dt>
                <dd class="col-sm-9"><code>{{ $usuario->token }}</code></dd>
            </dl>
        </div>
    </div>
</div>
@endsection
