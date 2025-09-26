<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TokenAuth
{
    /**
     * Autenticación por header:
     *   Authorization: Token <TOKEN>
     *   o X-Auth-Token: <TOKEN>
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = null;

        // Authorization: Token xxxxx
        $auth = $request->header('Authorization');
        if ($auth && str_starts_with($auth, 'Token ')) {
            $token = substr($auth, 6);
        }

        // X-Auth-Token (alternativa)
        if (!$token) {
            $token = $request->header('X-Auth-Token');
        }

        if (!$token) {
            return response()->json(['message' => 'Token requerido'], 401);
        }

        $user = Usuario::where('token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        // Autenticamos al usuario para este request (sin sesión)
        Auth::setUser($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
