<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Activity;
use App\Models\Company;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TicketController extends Controller
{

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

        $filters = (array) $request->user()->filters;
        $selected = array_filter(array_keys($filters), fn($v, $k) => array_values($filters)[$k], ARRAY_FILTER_USE_BOTH);
        $statuses = TicketStatus::whereIn(DB::raw('lower(name)'), $selected)->pluck('id')->toArray();

        $builder = Ticket::whereIn('id', $builder->get()->pluck('id'));
        $builder->whereIn('status_id', $statuses);


        $tickets = $builder->with('user')->paginate(config('app.defaults.pagination'));

        $q = $request->q;
        return Inertia::render('Tickets/Index', compact('tickets', 'q'));
    }

    public function show(Request $request, Ticket $ticket): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('show', $ticket);

        //$responses = $ticket->responses()->with('user')->paginate(15);

        $ticket->load('status', 'user', 'jobCard');
        $ticket->readers()->syncWithoutDetaching($request->user()->id);
        //$responses->each(fn($response) => $response->readers()->syncWithoutDetaching($request->user()->id));
        $statusOptions = TicketStatus::select(['id', 'name', 'description'])
            ->limit(500)
            ->get();

        $activityData = Activity::userFilter($ticket, $request->user());
        $activities = new LengthAwarePaginator($activityData, $activityData->count(), config('app.defaults.pagination'));
//        $activities = $ticket->activities()->filterPrivate()->latest()->with('subject')->paginate(config('app.defaults.pagination'));
        return Inertia::render('Tickets/Show', compact('ticket', 'activities', 'statusOptions'));
    }

    private function getCompanyOptions(User $user): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        if ($user->hasPermissionTo('create ticket for unassigned companies')) {
            return Company::select('id', 'name')->limit(500)->get();
        }

        return $user->companies()
            ->select('companies.id', 'companies.name')
            ->limit(500)
            ->get();
    }

    public function create(Request $request): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('create', Ticket::class);

        $companyOptions = $this->getCompanyOptions($request->user());

        return Inertia::render('Tickets/Create', compact('companyOptions'));
    }

    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $validated['current_team_id'] = $request->user()->current_team_id;
        $validated['status_id'] = config('app.defaults.status');
        $validated['owner_id'] = $request->user()->id;

        Ticket::create($validated);

        return redirect()->route('tickets.index');
    }

    public function destroy(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('destroy', $ticket);

        $ticket->delete();

        return redirect()->route('tickets.index');
    }

    public function edit(Request $request, Ticket $ticket): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('edit', $ticket);

        $companyOptions = $this->getCompanyOptions($request->user());

        return Inertia::render('Tickets/Edit', compact('ticket', 'companyOptions'));
    }
    public function update(Request $request, Ticket $ticket)
    {
        Gate::forUser($request->user())->authorize('edit', $ticket);

        $validated = $request->validate([
            'subject'    => 'required|string',
            'content'    => 'required|string',
            'company_id' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->user()->hasPermissionTo('create ticket for unassigned companies')) {
                        if (is_null(Company::find($value))) {
                            $fail('The '.$attribute.' is invalid');
                        }
                    } else {
                        if (DB::table('company_user')
                                ->select('company_id', 'user_id')
                                ->where('user_id', 1)
                                ->where('company_id', $value)
                                ->count() === 0) {
                            $fail('The user is not assigned to this'.$attribute.'');
                        }

                    }
                }
            ]
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket->id);
    }
}
