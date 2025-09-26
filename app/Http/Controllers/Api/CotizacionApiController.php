<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CotizacionC;
use Illuminate\Http\Request;

class CotizacionApiController extends Controller
{
    /**
     * GET /api/cotizaciones
     * Headers:
     *   Authorization: Token <TOKEN>
     * Query (opcionales):
     *   ?desde=YYYY-MM-DD&hasta=YYYY-MM-DD&min_total=123.45&page=1
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $q = CotizacionC::query()
            ->where('usuario_id', $user->id)
            ->withCount('detalles')
            ->withSum('detalles as total_items', 'cantidad')
            ->orderByDesc('id');

        if ($request->filled('desde')) {
            $q->whereDate('fecha_emision', '>=', $request->input('desde'));
        }
        if ($request->filled('hasta')) {
            $q->whereDate('fecha_emision', '<=', $request->input('hasta'));
        }
        if ($request->filled('min_total')) {
            $q->where('total_bruto', '>=', (float) $request->input('min_total'));
        }

        $paginator = $q->paginate(5);

        return response()->json([
            'data' => $paginator->getCollection()->map(function ($c) {
                return [
                    'id'             => $c->id,
                    'fecha_emision'  => $c->fecha_emision,
                    'total_bruto'    => (float) $c->total_bruto,
                    'detalles_count' => (int) ($c->detalles_count ?? 0),
                    'total_items'    => (int) ($c->total_items ?? 0),
                ];
            })->values(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
            ],
        ]);
    }
}
