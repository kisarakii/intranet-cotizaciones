@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header">
                    <strong>{{ __('messages.my_profile') }}</strong>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('perfil.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.first_name') }}</label>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $usuario->nombre) }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.last_name') }}</label>
                                <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                                       value="{{ old('apellido', $usuario->apellido) }}" required>
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.age') }}</label>
                                <input type="number" name="edad" min="1" max="120" class="form-control @error('edad') is-invalid @enderror"
                                       value="{{ old('edad', $usuario->edad) }}" required>
                                @error('edad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $usuario->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-3">

                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.new_password_optional') }}</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="{{ __('messages.leave_blank') }}">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.password_confirm') }}</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="{{ __('messages.repeat_password') }}">
                            </div>

                            <div class="col-12 d-flex gap-2 justify-content-end">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    {{ __('messages.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('messages.save_changes') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info solo-lectura útil (no editable) --}}
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('messages.account_info') }}</strong>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">{{ __('messages.id') }}</dt>
                        <dd class="col-sm-8">{{ $usuario->id }}</dd>

                        <dt class="col-sm-4">{{ __('messages.is_admin') }}</dt>
                        <dd class="col-sm-8">{{ $usuario->admin ? __('messages.yes') : __('messages.no') }}</dd>

                        <dt class="col-sm-4">{{ __('messages.token_hidden') }}</dt>
                        <dd class="col-sm-8"><span class="text-muted">{{ __('messages.not_editable') }}</span></dd>
                    </dl>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
