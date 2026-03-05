<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_perfil');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('view_perfil');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_perfil');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('update_perfil');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('delete_perfil');
    }
}
