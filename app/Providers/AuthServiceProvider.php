<?php

namespace App\Providers;

use App\Models\Usuario;
use App\Policies\UsuarioPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Usuario::class => UsuarioPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Registra las policies
        $this->registerPolicies();

        // Gate simple por si lo necesitas en algún middleware/route
        Gate::define('admin', function (Usuario $user) {
            return (bool) $user->admin;
        });
    }
}
