<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;

class CategoriaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_categoria');
    }

    public function view(User $user, Categoria $categoria): bool
    {
        return $user->hasPermissionTo('view_categoria');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_categoria');
    }

    public function update(User $user, Categoria $categoria): bool
    {
        return $user->hasPermissionTo('update_categoria');
    }

    public function delete(User $user, Categoria $categoria): bool
    {
        return $user->hasPermissionTo('delete_categoria');
    }
}
