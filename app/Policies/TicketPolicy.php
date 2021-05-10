<?php

namespace App\Policies;

use App\Models\Ticket;
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
        return $user->hasPermissionTo('create tickets');
    }

    public function show(User $user, Ticket $ticket): bool
    {
        return $user->hasPermissionTo('view tickets') || $user->ownsTicket($ticket);
    }

    public function subscribe(User $user, Ticket $ticket):bool
    {
        return $user->hasPermissionTo('subscribe to tickets') || $user->ownsTicket($ticket);
    }

    public function unsubscribe(User $user, Ticket $ticket):bool
    {
        return $user->hasPermissionTo('subscribe to tickets') || $user->ownsTicket($ticket);
    }

    public function reopen(User $user, Ticket $ticket):bool
    {
        return $user->hasPermissionTo('change ticket status') || $user->ownsTicket($ticket);
    }
}
