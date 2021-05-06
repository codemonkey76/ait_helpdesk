<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketSubscriptionController extends Controller
{
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('subscribe', $ticket);

        $ticket->subscribers()->syncWithoutDetaching($request->user()->id);

        return redirect()->back();
    }
    public function destroy(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('unsubscribe', $ticket);

        $ticket->subscribers()->detach($request->user()->id);

        return redirect()->back();
    }
}
