<?php

namespace App\Models;

use App\Traits\HasMustVerifyPhone;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasMustVerifyPhone;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use HasRoles;
    use Notifiable;
    use Searchable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    protected static function booted()
    {
        static::saving(function($user) {
           if ($user->isDirty('phone')) {
               $user->clearPhoneVerificationStatus();
           }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'terms', 'filters'
    ];
    protected $with = ['roles'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'filters'           => 'object'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)->orderBy('name');
    }

    public function ticketsRead(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'ticket_user', 'user_id', 'ticket_id');
    }

    public function ticketsSubscribed(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'subscriber_ticket', 'subscriber_id', 'ticket_id');
    }

    public function responsesRead(): BelongsToMany
    {
        return $this->belongsToMany(TicketResponse::class, 'response_user', 'user_id', 'ticket_response_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function ownsTicket(Ticket $ticket): bool
    {
        return ($this->id == $ticket->user_id);
    }

    public function getFiltersAttribute(): object
    {
        if (is_null($this->attributes['filters'])) {
            return (object)[
                'pending' => true,
                'open'    => true,
                'waiting' => true,
                'billing' => false,
                'closed'  => false
            ];
        }

        return json_decode($this->attributes['filters']);
    }

    public function hasCompany(Company $company): bool
    {
        return $this->companies()->find($company->id) !== null;
    }
    public function routeNotificationForNexmo($notification)
    {
        return $this->internationalFormatPhoneNumber;
    }
    public function getInternationalFormatPhoneNumberAttribute(): array|string|null
    {
        return preg_replace('/^0/','61',preg_replace('/\s+/','',$this->phone));
    }

    public function clearEmailVerificationStatus(): User
    {
        return $this->forceFill([
            'email_verified_at' => null,
        ]);
    }
    public function updatePhone($phone)
    {
        if ($this->phone !== $phone) {
            $this->forceFill([
                'phone' => $phone]);
            $this->clearPhoneVerificationStatus();
        }
    }
}
