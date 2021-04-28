<?php

namespace App\Actions\Notes;

use App\Models\Note;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateNote
{

    /**
     * @param $user
     * @param  array  $input
     * @return mixed
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Note::class);

        Validator::make($input, [
            'content' => ['required', 'string'],
        ])->validateWithBag('createNote');

        return Note::create([
            'content'       => $input['content'],
            'noteable_type' => $input['noteable_type'],
            'noteable_id'   => $input['noteable_id'],
            'user_id'       => $user->id
        ]);
    }
}
