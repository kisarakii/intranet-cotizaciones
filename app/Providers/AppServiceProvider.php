<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <-- Importante
use App\Models\Usuario;
use App\Observers\UsuarioObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Usar las vistas de Bootstrap 5 para paginación (en lugar de Tailwind)
        Paginator::useBootstrapFive();

        // Observer: notificación por email al crear usuario < 18
        Usuario::observe(UsuarioObserver::class);
    }
}
