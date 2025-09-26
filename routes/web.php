<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/home');
});

// Cambio de idioma por URL: /locale/es o /locale/en
Route::get('/locale/{lang}', function ($lang) {
    if (in_array($lang, ['es', 'en'])) {
        session(['locale' => $lang]);
    }
    return back();
})->name('locale.switch');

// Auth (login, register, reset, etc.)
Auth::routes();

// Home privada
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// === PERFIL (usuario autenticado edita sus propios datos) ===
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [App\Http\Controllers\PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [App\Http\Controllers\PerfilController::class, 'update'])->name('perfil.update');
});

// === COTIZACIONES (todos autenticados) ===
Route::middleware('auth')->group(function () {
    Route::get('/cotizaciones', [\App\Http\Controllers\CotizacionController::class, 'index'])->name('cotizaciones.index');
    Route::get('/cotizaciones/crear', [\App\Http\Controllers\CotizacionController::class, 'create'])->name('cotizaciones.create');
    Route::post('/cotizaciones', [\App\Http\Controllers\CotizacionController::class, 'store'])->name('cotizaciones.store');

    // Exportar a Excel (respeta filtros si vienen en la query string)
    Route::get('/cotizaciones/export', [\App\Http\Controllers\CotizacionController::class, 'export'])
        ->name('cotizaciones.export');
});

// === USUARIOS (solo Admin via Policy) ===
Route::middleware('auth')->group(function () {
    Route::resource('usuarios', \App\Http\Controllers\Admin\UsuarioController::class)
        ->parameters(['usuarios' => 'usuario']);
});
