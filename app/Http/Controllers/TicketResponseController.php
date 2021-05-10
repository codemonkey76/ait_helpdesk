<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\TicketStatus;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TicketResponseController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function create(Request $request, Ticket $ticket): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('create', TicketResponse::class);

        $statusOptions = TicketStatus::select(['id', 'name', 'description'])
            ->limit(500)
            ->get();
        return Inertia::render('Responses/Create', compact('statusOptions', 'ticket'));
    }

    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('create', TicketResponse::class);

        $validated = $request->validate([
            'content' => 'required'
        ]);

        $validated['user_id'] = $request->user()->id;


        if ($request->user()->hasPermissionTo('change ticket status'))
        {
            info('User has the permission to change the ticket status');
            $ticket->update(['status_id' => $request->status_id]);
            info('Ticket status should now be updated to ' . $request->status_id);
        }

        $ticket->responses()->create($validated);

        return redirect()->route('tickets.show', $ticket->id);
    }
}
