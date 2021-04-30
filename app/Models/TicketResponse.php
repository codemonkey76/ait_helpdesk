<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        static::saving(function ($response) {
           if ($response->user->hasRole('agent'))
                $response->ticket->update(['user_read_at' => null]);
           else
               $response->ticket->update(['agent_read_at' => null]);
        });
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
