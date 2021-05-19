<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NotePinController extends Controller
{
    public function store(Request $request, Note $note): RedirectResponse
    {
        Gate::authorize('pin', $note);

        $note->pin();

        return redirect()->back();
    }

    public function destroy(Request $request, Note $note): RedirectResponse
    {
        Gate::authorize('unpin', $note);

        $note->unpin();

        return redirect()->back();
    }
}
