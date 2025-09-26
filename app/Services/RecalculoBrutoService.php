<?php

namespace App\Services;

use App\Models\CotizacionC;
use App\Models\CotizacionD;
use Illuminate\Support\Facades\DB;

class RecalculoBrutoService
{
    /**
     * Recalcula total_bruto por cabecera como Σ(detalle.cantidad * detalle.precio_unitario).
     * - Soporta filtros por fecha y usuario.
     * - Procesa en chunks para no cargar todo en memoria.
     * - Opción dry-run para simular sin guardar.
     *
     * @param  string|null   $desde    YYYY-MM-DD
     * @param  string|null   $hasta    YYYY-MM-DD
     * @param  int|null      $userId   usuario_id opcional
     * @param  int           $chunk    tamaño del chunk
     * @param  bool          $dryRun   si true, no hace UPDATE
     * @param  callable|null $progress callback para mostrar barra de progreso
     * @return array{procesadas:int, actualizadas:int, sin_cambios:int}
     */
    public function recalcular(?string $desde, ?string $hasta, ?int $userId, int $chunk, bool $dryRun, ?callable $progress = null): array
    {
        $query = CotizacionC::query();

        if ($desde) {
            $query->whereDate('fecha_emision', '>=', $desde);
        }
        if ($hasta) {
            $query->whereDate('fecha_emision', '<=', $hasta);
        }
        if ($userId) {
            $query->where('usuario_id', $userId);
        }

        // Para la barra de progreso mostramos un total aproximado
        $total = (clone $query)->count();
        if ($progress) {
            $progress('start', $total ?: 0);
        }

        $procesadas = 0;
        $actualizadas = 0;
        $sinCambios = 0;

        // Procesamos en bloques por id para evitar saltos por actualización
        $query->orderBy('id')->chunkById($chunk, function ($cabeceras) use (&$procesadas, &$actualizadas, &$sinCambios, $dryRun, $progress) {
            foreach ($cabeceras as $cab) {
                // Calculamos el total bruto desde el detalle
                $nuevoTotal = (float) (CotizacionD::query()
                    ->where('cotizacion_id', $cab->id)
                    ->select(DB::raw('COALESCE(SUM(cantidad * precio_unitario),0) as total'))
                    ->value('total') ?? 0);

                $procesadas++;

                // Si no cambia, seguimos
                if ((float) $cab->total_bruto === $nuevoTotal) {
                    $sinCambios++;
                    if ($progress) $progress('advance');
                    continue;
                }

                if (!$dryRun) {
                    // Actualizamos solo la columna requerida sin tocar timestamps
                    DB::table('cotizacion_c')
                        ->where('id', $cab->id)
                        ->update(['total_bruto' => $nuevoTotal]);
                }

                $actualizadas++;
                if ($progress) $progress('advance');
            }
        });

        if ($progress) {
            $progress('finish');
        }

        return [
            'procesadas'   => $procesadas,
            'actualizadas' => $actualizadas,
            'sin_cambios'  => $sinCambios,
        ];
    }
}
