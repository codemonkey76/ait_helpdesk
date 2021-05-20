<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'user_id', 'time_spent', 'content'];

    protected static function booted()
    {
        static::saved(function (Job $job) {
            $job->ticket->activity()->create([
                'activatable_type' => 'job',
                'activatable_id'   => $job->id,
            ]);
        });
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
