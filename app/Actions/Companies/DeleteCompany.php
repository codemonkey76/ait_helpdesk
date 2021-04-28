<?php

namespace App\Actions\Companies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class DeleteCompany
{
    /**
     * Deletes an company
     * @param  Company  $company
     */
    public function delete(User $user, Company $company, array $input)
    {
        Gate::forUser($user)->authorize('delete', $company);
        Validator::make($input, [
            'password' => 'required|string|password',
        ])->validateWithBag('deleteCompany');

        $company->delete();
    }

}
