<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasNotes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Organization extends Model
{
    use HasFactory;
    use HasNotes;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'head_office_id'];

    public function headOffice(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'head_office_id');
    }

    protected static function booted() {
        static::saving(fn($organization) => $organization->setAttribute('headOfficeName', $organization->headOffice?->name));
        static::deleted(fn($organization) => $organization->notes()->delete());
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
