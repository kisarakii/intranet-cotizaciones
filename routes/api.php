<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CotizacionApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['token.auth'])->group(function () {
    // Lista de cotizaciones del usuario autenticado por token
    Route::get('/cotizaciones', [CotizacionApiController::class, 'index'])
        ->name('api.cotizaciones.index');
});
