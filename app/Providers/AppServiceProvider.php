<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Telescope\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'company' => 'App\Models\Company',
            'organization' => 'App\Models\Organization',
            'note' => 'App\Models\Note',
            'status_change' => 'App\Models\TicketStatusChange',
            'activity' => 'App\Models\Activity',
            'response' => 'App\Models\TicketResponse',
            'job' => 'App\Models\Job',
            'job_card' => 'App\Models\JobCard'
        ]);

        Ma
    }
}
