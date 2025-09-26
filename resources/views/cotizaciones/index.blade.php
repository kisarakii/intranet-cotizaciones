@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">{{ __('messages.quotes') }}</h4>
        <div class="d-flex gap-2">
            {{-- Link de Export que preserva filtros actuales --}}
            <a href="{{ route('cotizaciones.export', request()->only(['desde','hasta','min_total'])) }}"
               class="btn btn-outline-success">
                {{ __('messages.export') }}
            </a>
            <a href="{{ route('cotizaciones.create') }}" class="btn btn-primary">
                {{ __('messages.new_quote') }}
            </a>
        </div>
    </div>

    {{-- Filtros opcionales --}}
    <form class="card card-body mb-3" method="GET" action="{{ route('cotizaciones.index') }}">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">{{ __('messages.from') }}</label>
                <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('messages.to') }}</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('messages.min_gross') }}</label>
                <input type="number" step="0.01" name="min_total" value="{{ request('min_total') }}" class="form-control" placeholder="0.00">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button class="btn btn-outline-primary w-100">{{ __('messages.filter') }}</button>
                <a href="{{ route('cotizaciones.index') }}" class="btn btn-outline-secondary">{{ __('messages.clear') }}</a>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('messages.issue_date') }}</th>
                        <th class="text-end">{{ __('messages.gross_total') }}</th>
                        <th class="text-center">{{ __('messages.items_count') }}</th>
                        <th>{{ __('messages.user') }}</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($cotizaciones as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($c->fecha_emision)->format('Y-m-d H:i') }}</td>
                        <td class="text-end">{{ number_format($c->total_bruto, 2) }}</td>
                        <td class="text-center">
                            {{ $c->total_items ?? 0 }}
                            {{-- Nota: total_items = suma de cantidades (no número de líneas). Si prefieres # de líneas, usa $c->detalles_count --}}
                        </td>
                        <td>{{ optional($c->usuario)->nombre }} {{ optional($c->usuario)->apellido }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">{{ __('messages.no_quotes') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $cotizaciones->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection
