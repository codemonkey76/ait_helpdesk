<?php

namespace App\Models;

use App\Events\CompanySaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasNotes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Company extends Model
{
    use HasFactory;
    use HasNotes;
    use Searchable;

    protected $fillable = ['name', 'phone', 'address', 'address2', 'suburb', 'state', 'postcode', 'organization_id'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    protected static function booted()
    {
        static::saving(function ($company) {
            $company->setAttribute('organizationName', $company->organization?->name);
        });

        static::saved(function ($company) {
            $company->organization?->update(['head_office_id' => $company->id]);
        });

        static::updated(function ($company) {
            $org = Organization::find($company->original['organization_id']);
            if ($org?->head_office_id === $company->id) {
                $org->update(['head_office_id' => null]);
            }
        });

        static::deleted(function ($company) {
            $company->notes()->delete();
        });

    }
}
