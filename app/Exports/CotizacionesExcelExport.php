<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CotizacionesExcelExport implements WithMultipleSheets
{
    public function __construct(
        protected ?string $desde = null,
        protected ?string $hasta = null,
        protected ?float  $minTotal = null,
    ) {}

    public function sheets(): array
    {
        return [
            new ResumenCotizacionesSheet($this->desde, $this->hasta, $this->minTotal),
            new ProductosCotizadosSheet($this->desde, $this->hasta, $this->minTotal),
        ];
    }
}
