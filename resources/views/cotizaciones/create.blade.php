@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Nueva cotización</h4>

    <form method="POST" action="{{ route('cotizaciones.store') }}" class="card card-body">
        @csrf

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Fecha de emisión</label>
                <input type="datetime-local" name="fecha_emision"
                       value="{{ old('fecha_emision', now()->format('Y-m-d\TH:i')) }}"
                       class="form-control @error('fecha_emision') is-invalid @enderror" required>
                @error('fecha_emision') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle" id="itemsTable">
                <thead>
                    <tr>
                        <th style="width:45%">Producto</th>
                        <th style="width:15%" class="text-end">Precio unitario</th>
                        <th style="width:15%">Cantidad</th>
                        <th style="width:15%" class="text-end">Subtotal</th>
                        <th style="width:10%"></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Fila inicial --}}
                    <tr>
                        <td>
                            <select name="items[0][producto_sku]" class="form-select producto-select" required>
                                <option value="">Seleccione…</option>
                                @foreach($productos as $p)
                                    <option value="{{ $p->sku }}" data-precio="{{ $p->precio_unitario }}">
                                        {{ $p->sku }} — {{ $p->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('items.0.producto_sku') <div class="text-danger small">{{ $message }}</div> @enderror
                        </td>
                        <td class="text-end">
                            <span class="precio-unit">0.00</span>
                        </td>
                        <td>
                            <input type="number" min="1" value="1" class="form-control cantidad-input" name="items[0][cantidad]" required>
                            @error('items.0.cantidad') <div class="text-danger small">{{ $message }}</div> @enderror
                        </td>
                        <td class="text-end">
                            <span class="subtotal">0.00</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row" disabled>&times;</button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total estimado</th>
                        <th class="text-end"><span id="totalEstimado">0.00</span></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex gap-2 mb-3">
            <button type="button" id="addRow" class="btn btn-outline-primary">+ Agregar producto</button>
        </div>

        <div>
            <a href="{{ route('cotizaciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button class="btn btn-primary">Guardar cotización</button>
        </div>
    </form>
</div>

{{-- JS mínimo para clonar filas y recalcular totales en el cliente (el server recalcula por seguridad) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.querySelector('#itemsTable tbody');
    const addBtn = document.getElementById('addRow');
    const totalEstimadoEl = document.getElementById('totalEstimado');

    function recalcRow(tr) {
        const select = tr.querySelector('.producto-select');
        const precio = parseFloat(select?.selectedOptions[0]?.dataset?.precio || 0);
        tr.querySelector('.precio-unit').textContent = precio.toFixed(2);

        const cantInput = tr.querySelector('.cantidad-input');
        const cant = parseInt(cantInput.value || '0', 10);
        const subtotal = (precio * cant) || 0;
        tr.querySelector('.subtotal').textContent = subtotal.toFixed(2);

        recalcTotal();
    }

    function recalcTotal() {
        let total = 0;
        tbody.querySelectorAll('tr').forEach(tr => {
            const val = parseFloat(tr.querySelector('.subtotal').textContent || '0');
            total += isNaN(val) ? 0 : val;
        });
        totalEstimadoEl.textContent = total.toFixed(2);
    }

    function reindexRows() {
        [...tbody.querySelectorAll('tr')].forEach((tr, idx) => {
            tr.querySelectorAll('select, input').forEach(inp => {
                if (inp.name.includes('items[')) {
                    inp.name = inp.name.replace(/items\[\d+\]/, `items[${idx}]`);
                }
            });
            const removeBtn = tr.querySelector('.remove-row');
            removeBtn.disabled = (tbody.querySelectorAll('tr').length === 1);
        });
    }

    // Listeners iniciales
    tbody.addEventListener('change', function(e){
        const tr = e.target.closest('tr');
        if (tr) recalcRow(tr);
    });
    tbody.addEventListener('input', function(e){
        const tr = e.target.closest('tr');
        if (tr) recalcRow(tr);
    });

    // Agregar fila
    addBtn.addEventListener('click', function(){
        const last = tbody.querySelector('tr:last-child');
        const clone = last.cloneNode(true);

        // Reset valores
        clone.querySelector('.producto-select').value = '';
        clone.querySelector('.precio-unit').textContent = '0.00';
        clone.querySelector('.cantidad-input').value = '1';
        clone.querySelector('.subtotal').textContent = '0.00';
        clone.querySelectorAll('.text-danger').forEach(el => el.remove());

        tbody.appendChild(clone);
        reindexRows();
    });

    // Remover fila
    tbody.addEventListener('click', function(e){
        if (e.target.classList.contains('remove-row')) {
            if (tbody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
                reindexRows();
                recalcTotal();
            }
        }
    });

    // Calcular fila inicial
    recalcRow(tbody.querySelector('tr'));
});
</script>
@endsection
