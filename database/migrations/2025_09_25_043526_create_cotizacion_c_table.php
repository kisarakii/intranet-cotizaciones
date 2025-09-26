<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Cabecera de cotización: 'cotizacion_c'
    public function up(): void
    {
        Schema::create('cotizacion_c', function (Blueprint $table) {
            $table->increments('id');                         // PK autoincremental
            $table->unsignedInteger('usuario_id');            // FK -> usuarios.id
            $table->dateTime('fecha_emision');                // datetime
            $table->double('total_bruto')->default(0);        // double (sumatoria de detalle)
            $table->timestamp('fecha_registro')->useCurrent();// timestamp con default NOW()
            $table->timestamps();                             // created_at / updated_at

            // FK y ayuda de índices
            $table->foreign('usuario_id')
                  ->references('id')->on('usuarios')
                  ->onUpdate('cascade')->onDelete('restrict');

            $table->index(['usuario_id', 'fecha_emision']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion_c');
    }
};
