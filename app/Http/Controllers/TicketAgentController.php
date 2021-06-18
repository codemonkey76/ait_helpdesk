<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TicketAgentController extends Controller
{
    public function update(Request $request, Ticket $ticket)
    {
        Gate::forUser($request->user())->authorize('changeTicketAgent', $ticket);

        $validated = $request->validate([
            'agent_id' => [
                'nullable',
                Rule::in(User::permission('assign agent')->pluck('id'))
            ]
        ]);

        $ticket->assignAgent($validated['agent_id']);

        return redirect()->route('tickets.show', $ticket->id);
    }
}
