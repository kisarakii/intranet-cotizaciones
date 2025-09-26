<?php

namespace App\Console\Commands;

use App\Services\RecalculoBrutoService;
use Illuminate\Console\Command;

class RecalculoBrutoCommand extends Command
{
    /**
     * Nombre del comando de consola.
     * Ej: php artisan cotizacion:recalculo_bruto --desde=2025-01-01 --hasta=2025-12-31 --dry
     */
    protected $signature = 'cotizacion:recalculo_bruto
                            {--desde= : Fecha inicio (YYYY-MM-DD)}
                            {--hasta= : Fecha fin (YYYY-MM-DD)}
                            {--user= : Filtrar por usuario_id (opcional)}
                            {--chunk=200 : Tamaño de chunk para procesar en bloques}
                            {--dry : Simula el recalculo sin guardar}';

    /**
     * Descripción breve que aparece en "php artisan list".
     */
    protected $description = 'Recalcula total_bruto de cotizacion_c como Σ(detalle.cantidad * detalle.precio_unitario)';

    public function handle(RecalculoBrutoService $service): int
    {
        $desde  = $this->option('desde') ?: null;
        $hasta  = $this->option('hasta') ?: null;
        $userId = $this->option('user') ? (int) $this->option('user') : null;
        $chunk  = (int) ($this->option('chunk') ?: 200);
        $dry    = (bool) $this->option('dry');

        $this->info('Iniciando recalculo de total_bruto...');
        $this->line(sprintf(
            'Filtros -> desde: %s | hasta: %s | usuario_id: %s | chunk: %d | dry-run: %s',
            $desde ?: '-', $hasta ?: '-', $userId ? $userId : '-', $chunk, $dry ? 'sí' : 'no'
        ));

        $bar = null;
        $progressFn = function ($type, $value = null) use (&$bar) {
            if ($type === 'start') {
                $bar = $this->output->createProgressBar($value);
                $bar->start();
            } elseif ($type === 'advance') {
                $bar?->advance();
            } elseif ($type === 'finish') {
                $bar?->finish();
                $this->newLine(2);
            }
        };

        $result = $service->recalcular($desde, $hasta, $userId, $chunk, $dry, $progressFn);

        $this->table(
            ['Total procesadas', 'Actualizadas', 'Sin cambios', 'Dry-run'],
            [[
                $result['procesadas'],
                $result['actualizadas'],
                $result['sin_cambios'],
                $dry ? 'Sí' : 'No',
            ]]
        );

        $this->info('Recalculo finalizado.');
        return self::SUCCESS;
    }
}
