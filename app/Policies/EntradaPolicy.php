<?php

namespace App\Policies;

use App\Models\Entrada;
use App\Models\User;

class EntradaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_entrada');
    }

    public function view(User $user, Entrada $entrada): bool
    {
        return $user->hasPermissionTo('view_entrada');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_entrada');
    }

    public function update(User $user, Entrada $entrada): bool
    {
        return $user->hasPermissionTo('update_entrada');
    }

    public function delete(User $user, Entrada $entrada): bool
    {
        return $user->hasPermissionTo('delete_entrada') && $entrada->isRascunho();
    }
}
