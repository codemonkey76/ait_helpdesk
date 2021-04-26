<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list companies');
    }

    public function view(User $user, Company $company): bool
    {
        return $user->hasPermissionTo('show companies');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create companies');
    }

    public function update(User $user, Company $company): bool
    {
        return $user->hasPermissionTo('update companies');
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->hasPermissionto('delete companies');
    }
}
