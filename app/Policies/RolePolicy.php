<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        if ($user->hasPermissionTo('list roles')) {
            return true;
        }

        return false;
    }
    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('create roles')) {
            return true;
        }

        return false;
    }

    public function edit(User $user, Role $role): bool
    {
        if ($user->hasPermissionTo('edit roles')) {
            return true;
        }

        return false;
    }
    public function delete(User $user, Role $role): bool
    {
        if ($user->hasPermissionTo('delete roles')) {
            return true;
        }

        return false;
    }
}
