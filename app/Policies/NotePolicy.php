<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    public function pin(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('pin notes');
    }
    public function unpin(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('unpin notes');
    }
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create notes');
    }
    public function delete(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('delete notes');
    }
}
