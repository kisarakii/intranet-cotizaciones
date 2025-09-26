@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">
                {{ __('messages.welcome') }}, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }} 👋
            </h4>

            <p class="text-muted mb-0">
                {{ __('messages.dashboard_intro') }}
            </p>
        </div>
    </div>
</div>
@endsection
