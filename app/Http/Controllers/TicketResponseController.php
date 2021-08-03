<?php

namespace App\Http\Controllers;

use App\Enums\TICKET_STATUS;
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
        Gate::forUser($request->user())->authorize('create', [TicketResponse::class, $ticket]);

        $statusOptions = TicketStatus::select(['id', 'name', 'description'])
            ->limit(500)
            ->get();
        return Inertia::render('Responses/Create', compact('statusOptions', 'ticket'));
    }

    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('create', [TicketResponse::class, $ticket]);

        $validated = $request->validate([
            'content' => 'required',
            'private' => 'sometimes|boolean'
        ]);

        $validated['user_id'] = $request->user()->id;

        if (! $request->user()->hasPermissionTo('create private responses'))
        {
            unset($validated['private']);
        }

        if ($request->user()->hasPermissionTo('change ticket status'))
        {
            $ticket->update(['status_id' => $request->status_id ?? config('app.defaults.status')]);
        }

        if ($request->user()->id === $ticket->user_id && $ticket->status_id === TICKET_STATUS::WAITING)
        {
            $ticket->update(['status_id' => TICKET_STATUS::OPEN]);
        }

        $ticket->responses()->create($validated);

        return redirect()->route('tickets.show', $ticket->id);
    }

    public function destroy(Request $request, Ticket $ticket, TicketResponse $response): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('destroy', $response);

        $response->delete();

        return redirect()->route('tickets.show', $ticket->id);
    }

    public function edit(Request $request, Ticket $ticket, TicketResponse $response): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('edit', $response);

        $statusOptions = TicketStatus::select(['id', 'name', 'description'])
            ->limit(500)
            ->get();

        $response->load('ticket');

        return Inertia::render('Responses/Edit', compact('statusOptions', 'response'));
    }

    public function update(Request $request, Ticket $ticket, TicketResponse $response): RedirectResponse
    {
        Gate::forUSer($request->user())->authorize('edit', $response);

        $validated = $request->validate([
            'content' => 'required'
        ]);

        $response->update($validated);

        return redirect()->route('tickets.show', $ticket->id);
    }

}
