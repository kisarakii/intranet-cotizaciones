<?php

namespace App\Exports;

use App\Models\CotizacionC;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ResumenCotizacionesSheet implements FromQuery, WithHeadings, WithTitle
{
    public function __construct(
        protected ?string $desde = null,
        protected ?string $hasta = null,
        protected ?float  $minTotal = null,
    ) {}

    public function title(): string
    {
        return 'resumen cotizaciones';
    }

    public function headings(): array
    {
        return ['id', 'fecha_emision', 'total_bruto'];
    }

    public function query()
    {
        $q = CotizacionC::query()
            ->select(['id','fecha_emision','total_bruto'])
            ->orderBy('id');

        if ($this->desde) {
            $q->whereDate('fecha_emision', '>=', $this->desde);
        }
        if ($this->hasta) {
            $q->whereDate('fecha_emision', '<=', $this->hasta);
        }
        if ($this->minTotal !== null) {
            $q->where('total_bruto', '>=', $this->minTotal);
        }

        return $q;
    }
}
