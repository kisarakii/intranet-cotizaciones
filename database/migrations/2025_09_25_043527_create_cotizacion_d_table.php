<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Detalle de cotización: 'cotizacion_d'
    public function up(): void
    {
        Schema::create('cotizacion_d', function (Blueprint $table) {
            $table->increments('id');                         // PK autoincremental
            $table->unsignedInteger('cotizacion_id');         // FK -> cotizacion_c.id
            $table->string('producto_sku');                   // FK -> productos.sku
            $table->integer('cantidad');                      // int
            $table->double('precio_unitario');                // double (precio al momento)
            $table->timestamp('fecha_registro')->useCurrent();// timestamp con default NOW()
            $table->timestamps();                             // created_at / updated_at

            // FKs
            $table->foreign('cotizacion_id')
                  ->references('id')->on('cotizacion_c')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('producto_sku')
                  ->references('sku')->on('productos')
                  ->onUpdate('cascade')->onDelete('restrict');

            // Índices útiles para consultas
            $table->index(['cotizacion_id']);
            $table->index(['producto_sku']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion_d');
    }
};
