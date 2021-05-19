<?php

namespace App\Models;

use App\Traits\HasPinnable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Scout\Searchable;

class Note extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasPinnable;

    protected $fillable = ['content', 'is_pinned', 'noteable_type', 'noteable_id', 'user_id'];
    protected $with = ['user'];
    protected $casts = [
        'is_pinned' => 'boolean'
    ];

    public function noteable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
