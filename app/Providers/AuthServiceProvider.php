<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Note;
use App\Models\Team;
use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\CompanyPolicy;
use App\Policies\NotePolicy;
use App\Policies\TeamPolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Organization::class => OrganizationPolicy::class,
        Company::class => CompanyPolicy::class,
        Note::class => NotePolicy::class,
        Ticket::class => TicketPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user, $ability) {
            if ($user->hasRole('super-admin'))
                return true;
        });
    }
}
