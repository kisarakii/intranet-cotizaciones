<?php

namespace App\Observers;

use App\Mail\MinorUserAlert;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;

class UsuarioObserver
{
    /**
     * Al crear un usuario, si es menor de edad, avisamos a los administradores.
     * (Solo en create; no se notifica en updates).
     */
    public function created(Usuario $usuario): void
    {
        if ($usuario->edad !== null && (int) $usuario->edad < 18) {
            $this->notifyAdmins($usuario, 'created');
        }
    }

    /**
     * Envía el correo a todos los administradores.
     */
    protected function notifyAdmins(Usuario $usuario, string $event): void
    {
        // Recuperamos a todos los administradores activos
        $admins = Usuario::query()->where('admin', true)->get(['email', 'nombre', 'apellido']);

        foreach ($admins as $admin) {
            // Usamos un mailable Markdown, simple y legible
            Mail::to($admin->email)->send(new MinorUserAlert($usuario, $event));
        }
    }
}
