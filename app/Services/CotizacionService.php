<?php

namespace App\Services;

use App\Models\CotizacionC;
use App\Models\CotizacionD;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CotizacionService
{
    /**
     * Crea una cotización con detalle en una transacción.
     * - Toma precio_unitario real desde catálogo (seguridad).
     * - Calcula total_bruto = Σ (cantidad * precio_unitario).
     */
    public function crearCotizacion(Usuario $usuario, array $payload): CotizacionC
    {
        return DB::transaction(function () use ($usuario, $payload) {
            $fechaEmision = Carbon::parse($payload['fecha_emision']);

            $cab = CotizacionC::create([
                'usuario_id'    => $usuario->id,
                'fecha_emision' => $fechaEmision,
                'total_bruto'   => 0, // se recalcula abajo
                // 'fecha_registro' es useCurrent() en la DB
            ]);

            $total = 0.0;

            foreach ($payload['items'] as $item) {
                $sku      = $item['producto_sku'];
                $cantidad = (int) $item['cantidad'];

                /** @var Producto $prod */
                $prod = Producto::query()->where('sku', $sku)->firstOrFail();

                $precio = (float) $prod->precio_unitario;
                $subtotal = $precio * $cantidad;
                $total += $subtotal;

                CotizacionD::create([
                    'cotizacion_id'   => $cab->id,
                    'producto_sku'    => $sku,
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $precio,
                    // 'fecha_registro' useCurrent()
                ]);
            }

            $cab->update(['total_bruto' => $total]);

            // Refrescamos relaciones por si el controlador quiere contadores al vuelo
            return $cab->fresh(['usuario', 'detalles']);
        });
    }
}
