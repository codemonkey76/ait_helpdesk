<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketStatusChange extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = ['ticket_id', 'user_id', 'old_status_id', 'new_status_id'];
    protected $appends = ['userName', 'newStatusName', 'oldStatusName'];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
    public function getOldStatusNameAttribute()
    {
        return $this->oldStatus->name;
    }
    public function getNewStatusNameAttribute()
    {
        return $this->newStatus->name;
    }
    public function OldStatus() : BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'old_status_id');
    }
    public function NewStatus(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'new_status_id');
    }
}
