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
        // Allow agents to view all tickets
        if ($user->hasPermissionTo('view all tickets')) {
            return true;
        }

        // Allow unassigned tickets to be viewed by owners
        if ($ticket->company_id === null && $user->ownsTicket($ticket)) {
            return true;
        }

        // Allow assigned tickets to be viewed by managers that are assigned to the same company as the ticket
        if ($ticket->company_id !== null && $user->hasPermissionTo('view own company tickets') && $user->hasCompany($ticket->company)) {
            return true;
        }

        // Allow assigned tickets to be viewed by ticket owners only if they are also assigned to that company
        if ($ticket->company_id !== null && $user->ownsTicket($ticket) && $user->hasCompany($ticket->company)) {
            return true;
        }

        // Deny everyone else
        return false;
    }

    public function subscribe(User $user, Ticket $ticket):bool
    {
        return $user->hasPermissionTo('subscribe to tickets') || $user->ownsTicket($ticket);
    }

    public function unsubscribe(User $user, Ticket $ticket):bool
    {
        return $user->hasPermissionTo('subscribe to tickets') || $user->ownsTicket($ticket);
    }

    public function changeTicketStatus(User $user, Ticket $ticket):bool
    {
        if ($user->hasPermissionTo('change ticket status')) {
            return true;
        }

        return false;
    }
    public function destroy(User $user, Ticket $ticket): bool
    {
        if ($user->hasPermissionTo('delete tickets')) {
            return true;
        }

        return false;
    }

    public function edit(User $user, Ticket $ticket): bool
    {
        if ($user->hasPermissionTo('edit tickets')) {
            return true;
        }

        return false;
    }
}
