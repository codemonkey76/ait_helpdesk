<?php

namespace App\Models;

use App\Notifications\TicketRespondedTo;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class TicketResponse extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use RecordsActivity;

    protected $fillable = ['content', 'status_id', 'user_id', 'user_read_at', 'agent_read_at', 'private'];
    protected $appends = ['userName'];
    protected $with = ['user'];
    protected $casts = [
        'private' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    protected static function booted()
    {
        static::saved(function (TicketResponse $response) {
            $ticket = $response->ticket;

            $ticket->touch();

            if ($response->user_id !== 1000) {
                if ($ticket->pending_closure) {
                    $ticket->update(['pending_closure' => false]);
                }
            }

            $ticket->readers()->sync([$response->user_id]);

            $response->readers()->sync([$response->user_id]);

            //dump($ticket->toNotify($response));
            $ticket
                ->toNotify($response)
                ->each(fn($notifiable) => $notifiable->notify(new TicketRespondedTo($ticket, $response)));
        });

        static::deleting(function (TicketResponse $response) {
            $response->activity()->delete();
        });
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }


    public function readers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'response_user', 'user_id', 'ticket_response_id')->withTimestamps();
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
}
