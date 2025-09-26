<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionC extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_c';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usuario_id', 'fecha_emision', 'total_bruto', 'fecha_registro',
    ];

    protected $casts = [
        'fecha_emision'  => 'datetime',
        'fecha_registro' => 'datetime',
        'total_bruto'    => 'float',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function detalles()
    {
        return $this->hasMany(CotizacionD::class, 'cotizacion_id');
    }
}
