<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function favorite(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('favorite notes');
    }
    public function unfavorite(User $user, Note $note): bool
    {
        return $user->hasPermissionTo('unfavorite notes');
    }
}
