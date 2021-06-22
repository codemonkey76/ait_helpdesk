<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Bug extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['subject', 'content'];
    protected $appends = ['userName'];

    protected static function booted() {
        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('user_id', '=', Auth::id());
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
}
