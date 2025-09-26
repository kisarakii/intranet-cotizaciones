<?php

namespace App\Policies;

use App\Models\Usuario;

class UsuarioPolicy
{
    // Sólo admin puede gestionar usuarios
    public function viewAny(Usuario $user): bool   { return (bool) $user->admin; }
    public function view(Usuario $user, Usuario $model): bool { return (bool) $user->admin; }
    public function create(Usuario $user): bool    { return (bool) $user->admin; }
    public function update(Usuario $user, Usuario $model): bool { return (bool) $user->admin; }
    public function delete(Usuario $user, Usuario $model): bool { return (bool) $user->admin; }
}
