<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        if ($user->hasPermissionTo('create job')) {
            return true;
        }

        return false;
    }
}
