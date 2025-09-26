<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductosCotizadosSheet implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        protected ?string $desde = null,
        protected ?string $hasta = null,
        protected ?float  $minTotal = null,
    ) {}

    public function title(): string
    {
        return 'productos cotizados';
    }

    public function headings(): array
    {
        return ['producto_sku', 'nombre', 'veces_cotizados', 'total_cantidad'];
    }

    public function collection()
    {
        // Agregamos join con cabecera para respetar filtros de fecha y total
        $q = DB::table('cotizacion_d as d')
            ->join('productos as p', 'p.sku', '=', 'd.producto_sku')
            ->join('cotizacion_c as c', 'c.id', '=', 'd.cotizacion_id')
            ->select([
                'p.sku as producto_sku',
                'p.nombre as nombre',
                DB::raw('COUNT(d.id) as veces_cotizados'),
                DB::raw('SUM(d.cantidad) as total_cantidad'),
            ])
            ->groupBy('p.sku', 'p.nombre')
            ->orderBy('p.nombre');

        if ($this->desde) {
            $q->whereDate('c.fecha_emision', '>=', $this->desde);
        }
        if ($this->hasta) {
            $q->whereDate('c.fecha_emision', '<=', $this->hasta);
        }
        if ($this->minTotal !== null) {
            $q->where('c.total_bruto', '>=', $this->minTotal);
        }

        return $q->get();
    }
}
