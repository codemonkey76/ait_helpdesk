<?php

namespace App\Models;

use App\Notifications\TicketCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Ticket extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    const EXCERPT_LENGTH = 50;

    protected $appends = ['excerpt', 'isSubscribed', 'jobSummary', 'timeSummary'];
    protected $fillable = ['subject', 'content', 'company_id', 'user_id', 'current_team_id', 'status_id', 'owner_id', 'assigned_agent_id'];

    protected static function booted()
    {
        static::saving(function (Ticket $ticket) {

            if (!is_null($ticket->id)) {
                if ($ticket->isDirty('status_id')) {
                    $statusChange = TicketStatusChange::create([
                        'ticket_id'     => $ticket->id,
                        'user_id'       => auth()->user()->id,
                        'old_status_id' => $ticket->getOriginal('status_id') ?? config('app.defaults.status'),
                        'new_status_id' => $ticket->status_id ?? config('app.defaults.status')
                    ]);
                }
            }

            $ticket->setAttribute('company_name', $ticket->company?->name);
        });
        static::created(function (Ticket $ticket) {
            $ticket->readers()->sync([$ticket->user_id]);

            User::permission('notified of new tickets')->each(fn($user) => $user->notify(new TicketCreated($ticket)));

        });


        static::addGlobalScope('sorted', function (Builder $builder) {
            $builder->orderBy('updated_at', 'desc');
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class);
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit(html_entity_decode(strip_tags(str_replace('<', ' <', $this->attributes['content']))), Ticket::EXCERPT_LENGTH);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(TicketResponse::class);
    }

    public function readers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ticket_user', 'ticket_id', 'user_id')->withTimestamps();
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriber_ticket', 'ticket_id', 'subscriber_id')->withTimestamps();
    }

    public function getIsSubscribedAttribute(): bool
    {
        return $this->subscribers()->where('subscriber_id', auth()->id())->count() > 0;
    }

    public function activity(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function updateStatus($ticketStatus)
    {
        Gate::forUser(auth()->user())->authorize('changeTicketStatus', $this);

        $this->update(['status_id' => $ticketStatus]);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function addJob(Carbon $date, int $timeSpent, string $content, User $user): Model
    {
        return $this->jobs()->create([
            'date'       => $date,
            'user_id'    => $user->id,
            'time_spent' => $timeSpent,
            'content'    => $content
        ]);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toNotify(TicketResponse $response): Collection
    {
        $notifiables = collect();

        if ($response->private) {
            return $notifiables;
        }

        if (!is_null($this->agent) && $response->user_id !== $this->agent->id) {
            $notifiables->push($this->agent);
        }

        if (!is_null($this->owner) &&
            !$notifiables->contains($this->owner) &&
            $response->user_id !== $this->owner->id) {

            $notifiables->push($this->owner);
        }

        return $notifiables->merge($this->subscribers->reject(fn($value, $key) => $response->user_id===$value->id || $notifiables->contains($value)));
    }

    public function jobCard(): HasOne
    {
        return $this->hasOne(JobCard::class);
    }

    public function activities(): HasMany
    {
        if (auth()->user()->can('see private responses'))
        {
            return $this->hasMany(Activity::class);
        }

        return $this->hasMany(Activity::class);
    }

    public function getJobSummaryAttribute()
    {
        return $this->jobs()->orderBy('date')->get()->implode('summary', PHP_EOL.PHP_EOL.PHP_EOL);
    }

    public function getTimeSummaryAttribute()
    {
        return $this->jobs()->sum('time_spent');
    }
}
