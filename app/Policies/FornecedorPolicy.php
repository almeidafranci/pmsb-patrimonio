<?php

namespace App\Policies;

use App\Models\Fornecedor;
use App\Models\User;

class FornecedorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_fornecedor');
    }

    public function view(User $user, Fornecedor $fornecedor): bool
    {
        return $user->hasPermissionTo('view_fornecedor');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_fornecedor');
    }

    public function update(User $user, Fornecedor $fornecedor): bool
    {
        return $user->hasPermissionTo('update_fornecedor');
    }

    public function delete(User $user, Fornecedor $fornecedor): bool
    {
        return $user->hasPermissionTo('delete_fornecedor');
    }

    public function restore(User $user, Fornecedor $fornecedor): bool
    {
        return $user->hasPermissionTo('delete_fornecedor');
    }

    public function forceDelete(User $user, Fornecedor $fornecedor): bool
    {
        return $user->hasPermissionTo('delete_fornecedor');
    }
}
