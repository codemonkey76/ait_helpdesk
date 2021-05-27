<?php

namespace App\Policies;

use App\Models\Job;
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
    public function edit(User $user, Job $job)
    {
        if ($user->hasPermissionto('edit all jobs')) {
            return true;
        }

        if ($user->id === $job->user_id && $user->hasPermissionto('edit own job')) {
            return true;
        }

        return false;
    }
    public function delete(User $user, Job $job)
    {
        if ($user->hasPermissionto('delete all jobs')) {
            return true;
        }

        if ($user->id === $job->user_id && $user->hasPermissionto('delete own job')) {
            return true;
        }

        return false;
    }
}
