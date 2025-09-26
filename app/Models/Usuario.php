<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Para Auth
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre', 'apellido', 'edad',
        'email', 'password', 'token', 'admin',
    ];

    // Ocultamos credenciales y secretos en serialización JSON
    protected $hidden = ['password', 'remember_token', 'token'];

    protected $casts = [
        'admin' => 'boolean',
        'edad'  => 'integer',
    ];

    // Relaciones
    public function cotizaciones()
    {
        return $this->hasMany(CotizacionC::class, 'usuario_id');
    }

    // Helper para token
    public static function generarToken(): string
    {
        return Str::random(40);
    }
}
