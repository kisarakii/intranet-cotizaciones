<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionD extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_d';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'cotizacion_id', 'producto_sku', 'cantidad', 'precio_unitario', 'fecha_registro',
    ];

    protected $casts = [
        'cantidad'        => 'integer',
        'precio_unitario' => 'float',
        'fecha_registro'  => 'datetime',
    ];

    public function cabecera()
    {
        return $this->belongsTo(CotizacionC::class, 'cotizacion_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_sku', 'sku');
    }
}
