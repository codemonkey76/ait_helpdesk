<?php

namespace App\Actions\Organization;

use App\Organization;

class CreateOrganization
{

    /**
     * Validate and create a new organization.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Organization::class);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createOrganization');

        return Organization::create([
            'name' => $input['name'],
        ]));
    }

}