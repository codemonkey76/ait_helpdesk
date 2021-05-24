<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user): bool
    {
        if ($user->hasPermissionTo('list permissions')) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('create permissions')) {
            return true;
        }

        return false;
    }

    public function edit(User $user, Permission $permission): bool
    {
        if ($user->hasPermissionTo('edit permissions')) {
            return true;
        }

        return false;
    }

    public function destroy(User $user, Permission $permission): bool
    {
        if ($user->hasPermissionTo('delete permissions')) {
            return true;
        }

        return false;
    }
}
