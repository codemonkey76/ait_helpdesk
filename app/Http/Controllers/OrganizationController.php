<?php

namespace App\Http\Controllers;

use App\Actions\Organizations\CreateOrganization;
use App\Actions\Organizations\DeleteOrganization;
use App\Actions\Organizations\UpdateOrganization;
use App\Models\Company;
use App\Models\Note;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Laravel\Jetstream\RedirectsActions;

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
     * @param  Request  $request
     * @return InertiaResponse
     */
    public function create(Request $request): InertiaResponse
    {
        return Inertia::render('Organizations/Create');
    }


    /**
     * Create a new organization.
     *
     * @param  Request  $request
     * @return RedirectResponse|Response
     */
    public function store(Request $request): RedirectResponse|Response
    {
        $creator = app(CreateOrganization::class);

        $creator->create($request->user(), $request->all());

        return redirect()->route('organizations.index');
    }

    /**
     * List the organizations.
     *
     * @param  Request  $request
     * @return InertiaResponse
     */
    public function index(Request $request): InertiaResponse
    {
        if ($request->has('q'))
            $organizations = Organization::search($request->q)->paginate(15);
        else
            $organizations = Organization::paginate(15);

        return Inertia::render('Organizations/Index', compact('organizations'));
    }

    /**
     * Show the organization page
     * @param  Request  $request
     * @param  Organization  $organization
     * @return InertiaResponse
     */
    public function show(Request $request, Organization $organization): InertiaResponse
    {
        if ($request->has('q')) {
            // Pluck ID's of notes using search terms
            $ids = Note::search($request->q)->where('noteable_id', $organization->id)->get()->pluck('id');

            // Query relation filtering by ID's
            $notes = $organization->notes()->whereIn('id', $ids)->with('user')->paginate(15);
        }
        else
            $notes = $organization->notes()->paginate(15);

        return Inertia::render('Organizations/Show', compact('organization', 'notes'));
    }

    /**
     * @param  Request  $request
     * @param  Organization  $organization
     * @return InertiaResponse
     */
    public function edit(Request $request, Organization $organization): InertiaResponse
    {
        $headOfficeOptions = Company::query()
            ->where('organization_id', $organization->id)
            ->select('id', 'name')
            ->limit(500)
            ->get();
        return Inertia::render('Organizations/Edit', compact('organization', 'headOfficeOptions'));
    }

    /**
     * Update the given organization.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Organization $organization): RedirectResponse
    {
        app(UpdateOrganization::class)->update($request->user(), $organization, $request->all());

        return redirect()->route('organizations.index');
    }


    /**
     * Delete the given organization
     * @param  Request  $request
     * @param  Organization  $organization
     * @return RedirectResponse
     */
    public function destroy(Request $request, Organization $organization): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string|password',
        ]);

        app(DeleteOrganization::class)->delete($organization);

        return redirect()->route('organizations.index');
    }

}
