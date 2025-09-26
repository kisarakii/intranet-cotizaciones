<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tabla 'productos' con PK string 'sku'
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->string('sku')->primary();                 // PK varchar
            $table->string('nombre');                         // varchar
            $table->double('precio_unitario');                // double (según esquema)
            $table->timestamps();                             // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
