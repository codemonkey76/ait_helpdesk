<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return InertiaResponse
     */
    public function index(Request $request): InertiaResponse
    {
        if ($request->has('q')) {
            $builder = Ticket::search($request->q);
        } else {
            $builder = Ticket::query();
        }

        // filter by current team.
        $builder->where('current_team_id', $request->user()->current_team_id);

        // filter by current user, if not allow to list tickets
        if (!$request->user()->hasPermissionTo('list tickets')) {
            $builder->where('user_id', $request->user()->id);
        }

        $filters = (array)$request->user()->filters;
        $selected = array_filter(array_keys($filters), fn($v, $k) => array_values($filters)[$k], ARRAY_FILTER_USE_BOTH);
        $statuses = TicketStatus::whereIn(DB::raw('lower(name)'), $selected)->pluck('id')->toArray();

        $builder->whereIn('status_id', $statuses);


        $tickets = $builder->paginate(15);


        return Inertia::render('Tickets/Index', compact('tickets'));
    }

    public function show(Request $request, Ticket $ticket): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('show', $ticket);

        $responses = $ticket->responses()->with('user')->paginate(15);

        $ticket->readers()->syncWithoutDetaching($request->user()->id);
        $responses->each(fn($response) => $response->readers()->syncWithoutDetaching($request->user()->id));
        $statusOptions = TicketStatus::select(['id', 'name', 'description'])
            ->limit(500)
            ->get();
        return Inertia::render('Tickets/Show', compact('ticket', 'responses', 'statusOptions'));
    }

    public function create(Request $request): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('create', Ticket::class);

        $companyOptions = $request->user()->companies()
            ->select('companies.id', 'companies.name')
            ->limit(500)
            ->get();
        return Inertia::render('Tickets/Create', compact('companyOptions'));
    }

    public function store(Request $request)
    {
        Gate::forUser($request->user())->authorize('create', Ticket::class);

        $validated = $request->validate([
            'subject'    => 'required|string',
            'content'    => 'required|string',
            'company_id' => [
                'nullable',
                Rule::exists('company_user')
                    ->where(fn($query) => $query->where('user_id', $request->user()->id)
                        ->where('company_id', $request->company_id))
            ]
        ]);
        $validated['user_id'] = $request->user()->id;
        $validated['current_team_id'] = $request->user()->current_team_id;
        $validated['status_id'] = config('app.defaults.status');

        Ticket::create($validated);

        return redirect()->route('tickets.index');
    }

    public function destroy(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('destroy', $ticket);

        $ticket->delete();

        return redirect()->route('tickets.index');
    }
}
