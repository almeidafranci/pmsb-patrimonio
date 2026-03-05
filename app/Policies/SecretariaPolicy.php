<?php

namespace App\Policies;

use App\Models\Secretaria;
use App\Models\User;

class SecretariaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_secretaria');
    }

    public function view(User $user, Secretaria $secretaria): bool
    {
        return $user->hasPermissionTo('view_secretaria');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_secretaria');
    }

    public function update(User $user, Secretaria $secretaria): bool
    {
        return $user->hasPermissionTo('update_secretaria');
    }

    public function delete(User $user, Secretaria $secretaria): bool
    {
        return $user->hasPermissionTo('delete_secretaria');
    }

    public function restore(User $user, Secretaria $secretaria): bool
    {
        return $user->hasPermissionTo('delete_secretaria');
    }

    public function forceDelete(User $user, Secretaria $secretaria): bool
    {
        return $user->hasPermissionTo('delete_secretaria');
    }
}
