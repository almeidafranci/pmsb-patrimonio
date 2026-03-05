<?php

namespace App\Policies;

use App\Models\UnidadeMedida;
use App\Models\User;

class UnidadeMedidaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_unidade_medida');
    }

    public function view(User $user, UnidadeMedida $unidadeMedida): bool
    {
        return $user->hasPermissionTo('view_unidade_medida');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_unidade_medida');
    }

    public function update(User $user, UnidadeMedida $unidadeMedida): bool
    {
        return $user->hasPermissionTo('update_unidade_medida');
    }

    public function delete(User $user, UnidadeMedida $unidadeMedida): bool
    {
        return $user->hasPermissionTo('delete_unidade_medida');
    }
}
