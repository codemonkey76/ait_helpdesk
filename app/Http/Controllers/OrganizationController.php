<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Jetstream\RedirectsActions;
use Laravel\Jetstream\Jetstream;

class OrganizationController extends Controller
{
    use RedirectsActions;
    
    /**
     * Show the organization creation screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Organization::class);

        return Inertia::render('Organizations/Create');
    }


    /**
     * Create a new organization.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $creator = app(CreateOrganization::class);

        $creator->create($request->user(), $request->all());

        return $this->redirectPath($creator);
    }

    /**
     * List the organizations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $organizations = Organization::paginate(20);

        return Jetstream::inertia()->render($request, 'Organizations/Index', compact('organizations'));
    }

}
