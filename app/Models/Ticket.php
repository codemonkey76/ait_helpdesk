<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Scout\Searchable;

class Ticket extends Model
{
    use HasFactory;
    use Searchable;

    const EXCERPT_LENGTH = 50;

    protected $with = ['user', 'company'];
    protected $appends = ['excerpt'];

    protected static function booted()
    {
        static::saving(function (Ticket $ticket) {
            $ticket->setAttribute('company_name', $ticket->company?->name);
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

    #[Pure] public function getExcerptAttribute(): string
    {
        return Str::limit($this->attributes['content'], Ticket::EXCERPT_LENGTH);
    }
    public function responses()
    {
        return $this->hasMany(TicketResponse::class);
    }
}
