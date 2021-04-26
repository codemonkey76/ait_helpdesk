<?php

namespace App\Actions\Companies;

use App\Models\Company;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateCompany
{

    /**
     * Validate and create a new company.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Company::class);

        Validator::make($input, [
            'name'            => ['required', 'string', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:255'],
            'address'         => ['nullable', 'string', 'max:255'],
            'address2'        => ['nullable', 'string', 'max:255'],
            'suburb'          => ['nullable', 'string', 'max:255'],
            'state'           => ['nullable', 'string', 'max:255'],
            'postcode'        => ['nullable', 'string', 'max:255'],
            'organization_id' => ['required', 'exists:organizations,id']
        ])->validateWithBag('createCompany');

        return Company::create([
            'name'            => $input['name'],
            'phone'           => $input['phone'],
            'address'         => $input['address'],
            'address2'        => $input['address2'],
            'suburb'          => $input['suburb'],
            'state'           => $input['state'],
            'postcode'        => $input['postcode'],
            'organization_id' => $input['organization_id']
        ]);
    }

}
