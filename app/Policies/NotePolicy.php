<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    public function favorite(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('favorite notes');
    }
    public function unfavorite(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('unfavorite notes');
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
