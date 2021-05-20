<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatusChange extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id', 'user_id', 'old_status_id', 'new_status_id'];
}
