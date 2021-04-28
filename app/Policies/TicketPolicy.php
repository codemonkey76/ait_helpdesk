<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list tickets');
    }

    public function create(User $user): bool
    {
        $user->hasPermissionTo('create tickets');
    }
}
