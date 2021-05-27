<?php

namespace App\Providers;

use App\LoggableMailMessage;
use App\Models\{Company, Note, Organization, Permission, Role, Team, Ticket, TicketResponse, User};
use App\Policies\{CompanyPolicy,
    NotePolicy,
    OrganizationPolicy,
    PermissionPolicy,
    RolePolicy,
    TeamPolicy,
    TicketPolicy,
    TicketResponsePolicy,
    UserPolicy};
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
        User::class           => UserPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class
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
            return (new LoggableMailMessage)
                ->greeting('Hello '. explode(' ', $user->name)[0])
                ->subject('Verify Email Address')
                ->bccIf(!is_null(config('app.defaults.bcc.email')), config('app.defaults.bcc.email'), config('app.defaults.bcc.name'))
                ->line('Please click the button below to verify your email address.')
                ->action('Verify Email Address', $verificationUrl)
                ->line('If you did not create an account, no further action is required.');
        });
    }
}
