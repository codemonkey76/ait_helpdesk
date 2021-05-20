<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = ['date', 'user_id', 'time_spent', 'content'];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
