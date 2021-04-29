<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Ticket;
use Illuminate\Http\Request;
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
            $tickets = Ticket::search($request->q)->paginate(15);
        else
            $tickets = Ticket::where('current_team_id', $request->user()->current_team_id)->paginate(15);

        return Inertia::render('Tickets/Index', compact('tickets'));
    }
}
