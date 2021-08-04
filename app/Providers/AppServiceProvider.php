<?php

namespace App\Providers;

use App\LoggableMailMessage;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;


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
        URL::forceScheme('https');
    }
}
