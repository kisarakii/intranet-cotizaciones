<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tabla 'usuarios' (no es la tabla 'users' por defecto de Laravel)
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');                         // PK autoincremental
            $table->string('nombre');                         // varchar
            $table->string('apellido');                       // varchar
            $table->integer('edad');                          // int
            $table->string('email')->unique();                // email único
            $table->string('password');                       // hash bcrypt
            $table->string('token')->unique();                // token único (lo generaremos al crear)
            $table->boolean('admin')->default(false);         // boolean (false por defecto)
            $table->timestamps();                             // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
