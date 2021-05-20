<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TicketStatusController extends Controller
{
    public function update(Request $request, Ticket $ticket)
    {
        Gate::forUser($request->user())->authorize('changeTicketStatus', $ticket);

        $validated = $request->validate([
            'status_id' => [
                'required',
                Rule::in(['1', '2', '3', '4', '5'])
            ]
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket->id);
    }
}
