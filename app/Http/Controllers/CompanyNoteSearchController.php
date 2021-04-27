<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CompanyNoteSearchController extends Controller
{
    public function index(Request $request, Company $company): InertiaResponse
    {
        // Pluck ID's of notes using search terms
        $ids = Note::search($request->search)->where('noteable_id', $company->id)->get()->pluck('id');

        // Query relation filtering by ID's
        $notes = $company->notes()->whereIn('id', $ids)->with('user')->paginate(15);

        return Inertia::render( 'Companies/Show', compact('company', 'notes'));
    }
}
