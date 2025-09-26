<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Fija el locale desde la sesión (y permite override temporal por ?lang=xx).
     * Si no hay nada en sesión, usa config('app.locale').
     */
    public function handle($request, Closure $next)
    {
        // Permitir override por query ?lang=es|en (útil para pruebas rápidas)
        if ($request->has('lang')) {
            $lang = $request->query('lang');
            if (in_array($lang, ['es','en'])) {
                Session::put('locale', $lang);
            }
        }

        $locale = Session::get('locale', config('app.locale', 'es'));
        App::setLocale($locale);

        return $next($request);
    }
}
