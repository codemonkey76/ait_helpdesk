<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

class SharePermissionsData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::share(array_filter([
            'permissions' => function () use ($request) {
                return [
                    'canListOrganizations' => $request->user()?->hasPermissionTo('list organizations'),
                    'canEditOrganizations' => $request->user()?->hasPermissionTo('update organizations'),
                    'canDeleteOrganizations' => $request->user()?->hasPermissionTo('delete organizations'),

                    'canListCompanies' => $request->user()?->hasPermissionTo('list companies'),
                    'canEditCompanies' => $request->user()?->hasPermissionTo('update companies'),
                    'canDeleteCompanies' => $request->user()?->hasPermissionTo('delete companies'),
                    'canListOwnTickets' => $request->user()?->hasPermissionTo('list own tickets'),

                    'canListUsers' => $request->user()?->hasPermissionTo('list users'),
                    'canEditUsers' => $request->user()?->hasPermissionTo('update users'),
                    'canDeleteUsers' => $request->user()?->hasPermissionto('delete users'),

                    'canDeleteNotes' => $request->user()?->hasPermissionTo('delete notes'),
                    'canViewTeamSettings' => $request->user()?->hasPermissionTo('view team settings'),
                    'canSwitchTeams' => $request->user()?->hasPermissionTo('switch teams'),
                    'canChangeTicketStatus' => $request->user()?->hasPermissionTo('change ticket status'),
                    'isAgent' => $request->user()?->hasRole('agent')
                ];
            },
        ]));

        return $next($request);
    }
}
