<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Laravel\Scout\Searchable;

class Note extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['content', 'is_favorite', 'noteable_type', 'noteable_id', 'user_id'];
    protected $with = ['user'];
    protected $casts = [
        'is_favorite' => 'boolean'
    ];

    public function noteable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorite()
    {
        $this->update(['is_favorite' => true]);
    }
    public function unfavorite()
    {
        $this->update(['is_favorite' => false]);
    }

}
