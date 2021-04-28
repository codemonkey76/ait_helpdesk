<?php

namespace App\Actions\Notes;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class DeleteNote
{
    /**
     * Delete the note
     *
     * @param  User  $user
     * @param  Note  $note
     * @throws AuthorizationException
     */
    public function delete(User $user, Note $note)
    {
        Gate::forUser($user)->authorize('delete', $note);

        $note->delete();
    }
}
