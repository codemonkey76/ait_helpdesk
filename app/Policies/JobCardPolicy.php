<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobCardPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('create job card')) {
            return true;
        }

        return false;
    }

}
