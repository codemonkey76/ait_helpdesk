<?php

namespace App\Http\Controllers;

use App\Actions\Notes\CreateNote;
use App\Actions\Notes\DeleteNote;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NoteController extends Controller
{


    public function store(Request $request): RedirectResponse
    {
        $creator = app(CreateNote::class);

        $creator->create($request->user(), $request->all());

        return back();
    }

    public function destroy(Request $request, Note $note): RedirectResponse
    {
        app(DeleteNote::class)->delete($request->user(), $note);
        return back();
    }
}
