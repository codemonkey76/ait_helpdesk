<?php

namespace App\Providers;

use App\Models\{Company, Note, Organization, Team, Ticket, TicketResponse, User};
use App\Policies\{CompanyPolicy,
    NotePolicy,
    OrganizationPolicy,
    TeamPolicy,
    TicketPolicy,
    TicketResponsePolicy,
    UserPolicy
};
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class           => TeamPolicy::class,
        Organization::class   => OrganizationPolicy::class,
        Company::class        => CompanyPolicy::class,
        Note::class           => NotePolicy::class,
        Ticket::class         => TicketPolicy::class,
        TicketResponse::class => TicketResponsePolicy::class,
        User::class           => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });

        VerifyEmail::toMailUsing(function (User $user, string $verificationUrl) {
            return (new MailMessage)
                ->greeting('Hello '. explode(' ', $user->name)[0])
                ->subject('Verify Email Address')
                ->line('Please click the button below to verify your email address.')
                ->action('Verify Email Address', $verificationUrl)
                ->line('If you did not create an account, no further action is required.');
        });
    }
}
