<?php

namespace App\Http\Controllers;

use App\Actions\Organization\CreateOrganization;
use App\Models\Organization;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Jetstream\RedirectsActions;
use Laravel\Jetstream\Jetstream;

class OrganizationController extends Controller
{
    use RedirectsActions;

    public function __construct()
    {
        $this->authorizeResource(Organization::class, 'organization');
    }

    /**
     * Show the organization creation screen.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        return Inertia::render('Organizations/Create');
    }


    /**
     * Create a new organization.
     *
     * @param Request $request
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $organizations = Organization::paginate(20);

        return Inertia::render('Organizations/Index', compact('organizations'));
    }

}
