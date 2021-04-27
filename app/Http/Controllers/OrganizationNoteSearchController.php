<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class OrganizationNoteSearchController extends Controller
{
    public function index(Request $request, Organization $organization): InertiaResponse
    {
        // Pluck ID's of notes using search terms
        $ids = Note::search($request->search)->where('noteable_id', $organization->id)->get()->pluck('id');

        // Query relation filtering by ID's
        $notes = $organization->notes()->whereIn('id', $ids)->with('user')->paginate(15);

        return Inertia::render( 'Organizations/Show', compact('organization', 'notes'));
    }
}
