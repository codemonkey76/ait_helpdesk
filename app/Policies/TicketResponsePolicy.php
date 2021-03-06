<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketResponsePolicy
{
    use HandlesAuthorization;

    public function create(User $user, Ticket $ticket): bool
    {
        if ($user->hasPermissionTo('respond to all tickets')) {
            return true;
        }

        // Allow unassigned tickets to be responded to by owners
        if ($ticket->company_id === null && $user->ownsTicket($ticket)) {
            return true;
        }

        // Allow assigned tickets to be responded to by managers that are assigned to the same company as the ticket
        if ($ticket->company_id !== null && $user->hasPermissionTo('respond to own company tickets') && $user->hasCompany($ticket->company)) {
            return true;
        }

        // Allow assigned tickets to be responded to by ticket owners only if they are also assigned to that company
        if ($ticket->company_id !== null && $user->ownsTicket($ticket) && $user->hasCompany($ticket->company)) {
            return true;
        }

        // Deny everyone else
        return false;
    }

    public function destroy(User $user, TicketResponse $response): bool
    {
        if ($user->hasPermissionTo('delete all responses')) {
            return true;
        }

        if ($user->hasPermissionTo('delete own response') && ($user->id == $response->user_id)) {
            return true;
        }

        return false;
    }

    public function edit(User $user, TicketResponse $response): bool
    {
        if ($user->hasPermissionTo('edit all responses')) {
            return true;
        }

        if ($user->hasPermissionTo('edit own response') && ($user->id == $response->user_id)) {
            return true;
        }

        return false;
    }
}
