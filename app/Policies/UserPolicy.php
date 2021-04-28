<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list users');
    }

    public function view(User $user, User $user2): bool
    {
        return $user->hasPermissionTo('show users');
    }

    public function delete(User $user, User $user2): bool
    {
        return $user->hasPermissionto('delete users');
    }

    public function edit(User $user, User $user2): bool
    {
        return $user->hasPermissionTo('edit users');
    }
}
