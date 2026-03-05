<?php

namespace App\Policies;

use App\Models\Requisicao;
use App\Models\User;

class RequisicaoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_requisicao');
    }

    public function view(User $user, Requisicao $requisicao): bool
    {
        return $user->hasPermissionTo('view_requisicao');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_requisicao');
    }

    public function update(User $user, Requisicao $requisicao): bool
    {
        return $user->hasPermissionTo('update_requisicao');
    }

    public function delete(User $user, Requisicao $requisicao): bool
    {
        return $user->hasPermissionTo('delete_requisicao') && $requisicao->isRascunho();
    }
}
