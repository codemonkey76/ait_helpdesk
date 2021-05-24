<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
                    // Organizations
                    'canListOrganizations'   => $request->user()?->hasPermissionTo('list organizations'),
                    'canEditOrganizations'   => $request->user()?->hasPermissionTo('update organizations'),
                    'canDeleteOrganizations' => $request->user()?->hasPermissionTo('delete organizations'),

                    // Companies
                    'canListCompanies'   => $request->user()?->hasPermissionTo('list companies'),
                    'canEditCompanies'   => $request->user()?->hasPermissionTo('update companies'),
                    'canDeleteCompanies' => $request->user()?->hasPermissionTo('delete companies'),

                    // Tickets
                    'canListOwnTickets'  => $request->user()?->hasPermissionTo('list own tickets'),
                    'canChangeTicketStatus' => $request->user()?->hasPermissionTo('change ticket status'),
                    'canEditTicket' => $request->user()?->hasPermissionTo('edit tickets'),

                    // Responses
                    'canEditAllResponses' => $request->user()?->hasPermissionTo('edit all responses'),
                    'canEditOwnResponse' => $request->user()?->hasPermissionTo('edit own response'),
                    'canDeleteAllResponses' => $request->user()?->hasPermissionTo('delete all responses'),
                    'canDeleteOwnResponse' => $request->user()?->hasPermissionTo('delete own response'),

                    // Users
                    'canListUsers'   => $request->user()?->hasPermissionTo('list users'),
                    'canEditUsers'   => $request->user()?->hasPermissionTo('update users'),
                    'canDeleteUsers' => $request->user()?->hasPermissionto('delete users'),

                    // Notes
                    'canDeleteNotes'        => $request->user()?->hasPermissionTo('delete notes'),

                    // Teams
                    'canViewTeamSettings'   => $request->user()?->hasPermissionTo('view team settings'),
                    'canSwitchTeams'        => $request->user()?->hasPermissionTo('switch teams'),

                    // Jobs
                    'canCreateJob'          => $request->user()?->hasPermissionTo('create job'),

                    // Job Card
                    'canCreateJobCard' => $request->user()?->hasPermissionTo('create job card'),

                    // Permissions
                    'canListPermissions' => $request->user()?->hasPermissionTo('list permissions'),
                    'canCreatePermissions' => $request->user()?->hasPermissionTo('create permissions'),
                    'canEditPermissions' => $request->user()?->hasPermissionTo('edit permissions'),
                    'canDeletePermissions' => $request->user()?->hasPermissionTo('delete permissions'),
                    'canAttachPermissions' => $request->user()?->hasPermissionTo('attach permissions'),
                    'canDetachPermissions' => $request->user()?->hasPermissionTo('detach permissions'),

                    // Roles
                    'canListRoles' => $request->user()?->hasPermissionTo('list roles'),
                    'canEditRoles' => $request->user()?->hasPermissionTo('edit roles'),
                    'canCreateRoles' => $request->user()?->hasPermissionTo('create roles'),
                    'canDeleteRoles' => $request->user()?->hasPermissionTo('delete roles'),
                    'isAgent'               => $request->user()?->hasRole('agent'),
                ];
            },
            'recaptcha'   => function () use ($request) {
                return [
                    'site_key' => config('recaptcha.site_key')
                ];
            }
        ]));

        return $next($request);
    }
}
