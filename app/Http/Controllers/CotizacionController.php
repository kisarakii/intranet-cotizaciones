<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCotizacionRequest;
use App\Models\CotizacionC;
use App\Models\Producto;
use App\Services\CotizacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CotizacionesExcelExport;

class CotizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Todos deben estar autenticados
    }

    /**
     * Grilla: N°, Fecha emisión, Total bruto, Cantidad de productos, Usuario.
     * Filtros opcionales: rango de fechas y monto bruto mínimo.
     * Paginación: 5 por página (como pediste en opcionales).
     */
    public function index(Request $request)
    {
        $q = CotizacionC::query()
            ->with(['usuario'])
            // cantidad de líneas (veces productos cotizados)
            ->withCount('detalles')
            // suma de cantidades (total de unidades)
            ->withSum('detalles as total_items', 'cantidad')
            ->orderByDesc('id');

        // Filtros opcionales
        if ($request->filled('desde')) {
            $q->whereDate('fecha_emision', '>=', $request->date('desde'));
        }
        if ($request->filled('hasta')) {
            $q->whereDate('fecha_emision', '<=', $request->date('hasta'));
        }
        if ($request->filled('min_total')) {
            $q->where('total_bruto', '>=', (float) $request->input('min_total'));
        }

        $cotizaciones = $q->paginate(5)->withQueryString();

        return view('cotizaciones.index', compact('cotizaciones'));
    }

    /**
     * Form para crear cotización (1..n productos).
     */
    public function create()
    {
        $productos = Producto::orderBy('nombre')->get(['sku', 'nombre', 'precio_unitario']);
        return view('cotizaciones.create', compact('productos'));
    }

    /**
     * Guarda la cotización vía Service (transacción + cálculo server-side).
     */
    public function store(StoreCotizacionRequest $request, CotizacionService $service)
    {
        $cab = $service->crearCotizacion(Auth::user(), $request->validated());

        return redirect()
            ->route('cotizaciones.index')
            ->with('status', "Cotización #{$cab->id} creada correctamente.");
    }

    /**
     * Exporta Excel con 2 hojas:
     *  - resumen cotizaciones: id, fecha_emision, total_bruto
     *  - productos cotizados: sku, nombre, veces cotizados, total cantidad
     * Respeta filtros de la lista si vienen en la query.
     */
    public function export(Request $request)
    {
        $desde    = $request->input('desde');
        $hasta    = $request->input('hasta');
        $minTotal = $request->filled('min_total') ? (float) $request->input('min_total') : null;

        $export = new CotizacionesExcelExport($desde, $hasta, $minTotal);

        // Nombre de archivo con rango si aplica
        $filename = 'cotizaciones';
        if ($desde || $hasta) {
            $filename .= '_' . ($desde ?: '0000-00-00') . '_a_' . ($hasta ?: '9999-12-31');
        }
        if ($minTotal !== null) {
            $filename .= '_min' . str_replace('.', '_', (string) $minTotal);
        }
        $filename .= '.xlsx';

        return Excel::download($export, $filename);
    }
}
