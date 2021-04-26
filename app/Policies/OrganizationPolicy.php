<?php

namespace App\Policies;

use App\Models\{Organization, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list organizations');
    }

    public function view(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo('show organizations');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create organizations');
    }

    public function update(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo('update organizations');
    }

    public function delete(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo('delete organizations');
    }
}
