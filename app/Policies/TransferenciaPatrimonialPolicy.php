<?php

namespace App\Policies;

use App\Models\TransferenciaPatrimonial;
use App\Models\User;

class TransferenciaPatrimonialPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_transferencia');
    }

    public function view(User $user, TransferenciaPatrimonial $transferencia): bool
    {
        return $user->hasPermissionTo('view_transferencia');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('registrar_transferencia');
    }

    public function update(User $user, TransferenciaPatrimonial $transferencia): bool
    {
        return $user->hasPermissionTo('update_transferencia');
    }

    public function delete(User $user, TransferenciaPatrimonial $transferencia): bool
    {
        return $user->hasPermissionTo('delete_transferencia');
    }
}
