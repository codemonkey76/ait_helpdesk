<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): InertiaResponse
    {
        if ($request->has('q'))
            $builder = Ticket::search($request->q);
        else
            $builder = Ticket::query();

        // filter by current team.
        $builder->where('current_team_id', $request->user()->current_team_id);

        // filter by current user, if not allow to list tickets
        if (!$request->user()->hasPermissionTo('list tickets'))
            $builder->where('user_id', $request->user()->id);


        $tickets = $builder->paginate(15);

        return Inertia::render('Tickets/Index', compact('tickets'));
    }

    public function show(Request $request, Ticket $ticket): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('show', $ticket);

        $ticket->load('responses.user');

        return Inertia::render('Tickets/Show', compact('ticket'));
    }
}
