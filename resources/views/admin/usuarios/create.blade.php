@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">{{ __('messages.user_new') }}</h4>

    <form method="POST" action="{{ route('usuarios.store') }}" class="card card-body">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">{{ __('messages.first_name') }}</label>
                <input name="nombre" value="{{ old('nombre') }}"
                       class="form-control @error('nombre') is-invalid @enderror" required>
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ __('messages.last_name') }}</label>
                <input name="apellido" value="{{ old('apellido') }}"
                       class="form-control @error('apellido') is-invalid @enderror" required>
                @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">{{ __('messages.age') }}</label>
                <input type="number" min="0" name="edad" value="{{ old('edad') }}"
                       class="form-control @error('edad') is-invalid @enderror" required>
                @error('edad') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-8">
                <label class="form-label">{{ __('messages.email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ __('messages.password') }}</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ __('messages.password_confirm') }}</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="col-md-4">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="admin" value="1" id="adminCheck"
                        {{ old('admin') ? 'checked' : '' }}>
                    <label class="form-check-label" for="adminCheck">
                        {{ __('messages.is_admin') }}
                    </label>
                </div>
            </div>

            <div class="col-md-8">
                <label class="form-label">{{ __('messages.token_readonly_hint') }}</label>
                <input class="form-control" value="{{ __('messages.token_will_be_generated') }}" readonly>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">{{ __('messages.cancel') }}</a>
            <button class="btn btn-primary">{{ __('messages.save') }}</button>
        </div>
    </form>
</div>
@endsection
