<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Laravel espera este campo nullable (string 100 por convención)
            $table->string('remember_token', 100)->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
};
