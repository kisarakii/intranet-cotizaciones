<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'sku';
    public $incrementing = false; // PK string
    protected $keyType = 'string';

    protected $fillable = [
        'sku', 'nombre', 'precio_unitario',
    ];

    public function detalles()
    {
        return $this->hasMany(CotizacionD::class, 'producto_sku', 'sku');
    }
}
