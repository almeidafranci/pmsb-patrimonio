<?php

namespace App\Policies;

use App\Models\Movimentacao;
use App\Models\User;

class MovimentacaoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_movimentacao');
    }

    public function view(User $user, Movimentacao $movimentacao): bool
    {
        return $user->hasPermissionTo('view_movimentacao');
    }
}
