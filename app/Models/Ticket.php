<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Ticket extends Model
{
    use HasFactory;
    use Searchable;

    protected static function booted()
    {
        static::saving(function (Ticket $ticket) {
            $ticket->setAttribute('company_name', $ticket->company?->name);
        });
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
