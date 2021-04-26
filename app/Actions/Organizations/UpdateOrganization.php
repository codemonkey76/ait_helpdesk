<?php

namespace App\Actions\Organizations;

use App\Models\Organization;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateOrganization
{

    /**
     * Validate and update an organization.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @param Organization $organization
     * @return mixed
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function update($user, Organization $organization, array $input)
    {
        Gate::forUser($user)->authorize('update', $organization);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'head_office_id' => ['nullable', 'exists:companies,id']
        ])->validateWithBag('updateOrganization');

        return $organization->update([
            'name' => $input['name'],
            'head_office_id' => $input['head_office_id']
        ]);
    }

}
