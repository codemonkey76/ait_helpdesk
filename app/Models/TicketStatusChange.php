<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TicketStatusChange extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = ['ticket_id', 'user_id', 'old_status_id', 'new_status_id'];
}
