<?php

namespace App\Policies;

use App\Models\Tombamento;
use App\Models\User;

class TombamentoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_tombamento');
    }

    public function view(User $user, Tombamento $tombamento): bool
    {
        return $user->hasPermissionTo('view_tombamento');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_tombamento');
    }

    public function update(User $user, Tombamento $tombamento): bool
    {
        return $user->hasPermissionTo('update_tombamento');
    }

    public function delete(User $user, Tombamento $tombamento): bool
    {
        return $user->hasPermissionTo('delete_tombamento');
    }

    public function restore(User $user, Tombamento $tombamento): bool
    {
        return $user->hasPermissionTo('delete_tombamento');
    }

    public function forceDelete(User $user, Tombamento $tombamento): bool
    {
        return $user->hasPermissionTo('delete_tombamento');
    }
}
