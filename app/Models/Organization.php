<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasNotes;
use Laravel\Scout\Searchable;

class Organization extends Model
{
    use HasFactory;
    use HasNotes;
    use Searchable;

    protected $fillable = ['name', 'head_office_id'];

    public function headOffice()
    {
        return $this->belongsTo(Company::class, 'head_office_id');
    }

    protected static function booted() {
        static::saving(fn($organization) => $organization->setAttribute('headOfficeName', $organization->headOffice?->name));
        static::deleted(fn($organization) => $organization->notes()->delete());
    }
}
