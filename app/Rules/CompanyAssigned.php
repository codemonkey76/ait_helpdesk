<?php

namespace App\Rules;

use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CompanyAssigned implements Rule
{
    private User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function passes($attribute, $value)
    {
        if ($this->user->hasPermissionTo('create ticket for unassigned companies') && !is_null(Company::find($value))) {
            return true;
        }

        if (DB::table('company_user')
            ->select('company_id', 'user_id')
            ->where('user_id', $this->user->id)
            ->where('company_id', $value)
            ->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid :attribute provided.';
    }
}
