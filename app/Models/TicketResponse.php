<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class TicketResponse extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['content', 'status_id', 'user_id', 'user_read_at', 'agent_read_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    protected static function booted()
    {
        static::saved(function (TicketResponse $response) {
            $ticket = $response->ticket;

            $ticket->touch();
            $ticket->readers()->sync([$response->user_id]);

            $response->readers()->sync([$response->user_id]);

            $ticket->activity()->create([
                'activatable_type' => 'response',
                'activatable_id'   => $response->id,
            ]);

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
}
