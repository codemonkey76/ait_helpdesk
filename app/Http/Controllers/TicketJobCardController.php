<?php

namespace App\Http\Controllers;

use App\Models\JobCard;
use App\Models\Ticket;
use App\Rules\Multiple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketJobCardController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        Gate::forUser($request->user())->authorize('create', JobCard::class);

        $validated = $request->validate([
            'time_spent' => [
                'required',
                'numeric',
                new Multiple
            ],
            'content' => 'required'
        ]);

        $ticket->jobCard()->create($validated);

        return redirect()->route('tickets.show', $ticket->id);
    }
}
