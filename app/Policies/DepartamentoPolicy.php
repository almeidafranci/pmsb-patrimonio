<?php

namespace App\Policies;

use App\Models\Departamento;
use App\Models\User;

class DepartamentoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_departamento');
    }

    public function view(User $user, Departamento $departamento): bool
    {
        return $user->hasPermissionTo('view_departamento');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_departamento');
    }

    public function update(User $user, Departamento $departamento): bool
    {
        return $user->hasPermissionTo('update_departamento');
    }

    public function delete(User $user, Departamento $departamento): bool
    {
        return $user->hasPermissionTo('delete_departamento');
    }

    public function restore(User $user, Departamento $departamento): bool
    {
        return $user->hasPermissionTo('delete_departamento');
    }

    public function forceDelete(User $user, Departamento $departamento): bool
    {
        return $user->hasPermissionTo('delete_departamento');
    }
}
