<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NoteFavoriteController extends Controller
{
    public function store(Request $request, Note $note): RedirectResponse
    {
        Gate::authorize('favorite', $note);

        $note->favorite();

        return redirect()->back();
    }

    public function destroy(Request $request, Note $note): RedirectResponse
    {
        Gate::authorize('unfavorite', $note);

        $note->unfavorite();

        return redirect()->back();
    }
}
