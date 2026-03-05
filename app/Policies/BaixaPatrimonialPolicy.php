<?php

namespace App\Policies;

use App\Models\BaixaPatrimonial;
use App\Models\User;

class BaixaPatrimonialPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_baixa');
    }

    public function view(User $user, BaixaPatrimonial $baixa): bool
    {
        return $user->hasPermissionTo('view_baixa');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('registrar_baixa');
    }

    public function update(User $user, BaixaPatrimonial $baixa): bool
    {
        return $user->hasPermissionTo('update_baixa');
    }

    public function delete(User $user, BaixaPatrimonial $baixa): bool
    {
        return $user->hasPermissionTo('delete_baixa');
    }
}
