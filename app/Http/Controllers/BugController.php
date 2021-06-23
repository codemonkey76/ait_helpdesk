<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use GrahamCampbell\GitHub\Facades\GitHub;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class BugController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => 'required',
            'content' => 'required'
        ]);
        $validated['user_id'] = auth()->id();

        $issue = [
            'title' => $validated['subject'],
            'body' => $validated['content']
        ];
        GitHub::issues()->create(config('github.connections.main.user'), config('github.connections.main.repo'), $issue);
        
        $request->user()->bugs()->create($validated);

        return redirect()->route('dashboard');
    }

    public function index(Request $request): InertiaResponse
    {
        $bugSearch = $request->has('q') ? Bug::search($request->q)->get()->pluck('id') : null;

        $bugs = $request->user()->hasPermissionTo('see all bugs')
            ? Bug::query()
                ->withoutGlobalScope('user')
                ->when($bugSearch, fn($query) => $query->whereIn('id', $bugSearch))
                ->paginate(config('app.defaults.pagination'))
            : Bug::query()
                ->when($bugSearch, fn($query) => $query->whereIn('id', $bugSearch))
                ->paginate(config('app.defaults.pagination'));

        $q = $request->q;

        return Inertia::render('Bugs/Index', compact('bugs', 'q'));
    }

    public function show(Request $request, Bug $bug)
    {

    }

    public function update(Request $request, Bug $bug)
    {

    }

    public function create(Request $request): InertiaResponse
    {
        return Inertia::render('Bugs/Create');
    }
}
