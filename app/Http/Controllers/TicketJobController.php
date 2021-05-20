<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Ticket;
use App\Models\User;
use App\Rules\Multiple;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TicketJobController extends Controller
{
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('create', Job::class);

        $validated = $request->validate([
            'date' => 'required',
            'user_id' => [
                'required',
                Rule::in(User::permission('create job')->pluck('id'))
            ],
            'time_spent' => [
                'required',
                'numeric',
                new Multiple
            ],
            'content' => 'required|string'
        ]);

        $ticket->jobs()->create($validated);

        return redirect()->route('tickets.show', $ticket->id);
    }
}
