<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_usuario');
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('view_usuario');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_usuario');
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermissionTo('update_usuario');
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->hasPermissionTo('delete_usuario');
    }
}
