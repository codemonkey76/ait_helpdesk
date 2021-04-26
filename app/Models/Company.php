<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasNotes;
use Illuminate\Support\Facades\Log;
use Laravel\Scout\Searchable;

class Company extends Model
{
    use HasFactory;
    use HasNotes;
    use Searchable;

    protected $fillable = ['name', 'phone', 'address', 'address2', 'suburb', 'state', 'postcode', 'organization_id'];
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    protected static function booted() {
        static::saving(function($company) {
            $company->setAttribute('organizationName', $company->organization?->name);

            $org = Organization::find($company->original['organization_id']);
            if ($org?->head_office_id === $company->id) {
                $org->update(['head_office_id' => null]);
            }
        });
    }
}
