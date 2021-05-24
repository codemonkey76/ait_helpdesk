<?php

namespace App\Http\Controllers;

use App\Actions\Companies\CreateCompany;
use App\Actions\Companies\DeleteCompany;
use App\Actions\Companies\UpdateCompany;
use App\Models\Company;
use App\Models\Note;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Laravel\Jetstream\RedirectsActions;

class CompanyController extends Controller
{
    use RedirectsActions;

    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    /**
     * Show the company creation screen.
     *
     * @param  Request  $request
     * @return InertiaResponse
     */
    public function create(Request $request): InertiaResponse
    {
        $organizationOptions = Organization::query()
            ->select('id', 'name')
            ->limit(500)
            ->get();
        return Inertia::render('Companies/Create', compact('organizationOptions'));
    }

    /**
     * List the companies.
     *
     * @param  Request  $request
     * @return InertiaResponse
     */
    public function index(Request $request): InertiaResponse
    {
        if ($request->has('q'))
            $companies = Company::search($request->q)->paginate(config('app.defaults.pagination'));
        else
            $companies = Company::paginate(config('app.defaults.pagination'));

        return Inertia::render('Companies/Index', compact('companies'));
    }

    /**
     * Show the company page
     * @param  Request  $request
     * @param  Company  $company
     * @return InertiaResponse
     */
    public function show(Request $request, Company $company): InertiaResponse
    {
        if ($request->has('q')) {
            // Pluck ID's of notes using search terms
            $ids = Note::search($request->q)->where('noteable_id', $company->id)->get()->pluck('id');

            // Query relation filtering by ID's
            $notes = $company->notes()->whereIn('id', $ids)->with('user')->paginate(15);
        }
        else
            $notes = $company->notes()->paginate(15);

        return Inertia::render('Companies/Show', compact('company', 'notes'));
    }

    /**
     * @param  Request  $request
     * @param  Company  $company
     * @return InertiaResponse
     */
    public function edit(Request $request, Company $company): InertiaResponse
    {
        $organizationOptions = Organization::query()
            ->select('id', 'name')
            ->limit(500)
            ->get();

        return Inertia::render('Companies/Edit', compact('company', 'organizationOptions'));
    }


    /**
     * Update the given company
     * @param  Request  $request
     * @param  Company  $company
     * @return RedirectResponse
     */
    public function update(Request $request, Company $company): RedirectResponse
    {
        app(UpdateCompany::class)->update($request->user(), $company, $request->all());

        return redirect()->route('companies.index');
    }

    /**
     * Create a new company.
     *
     * @param  Request  $request
     * @return RedirectResponse|Response
     */
    public function store(Request $request): RedirectResponse
    {
        $creator = app(CreateCompany::class);

        $creator->create($request->user(), $request->all());

        return redirect()->route('companies.index');
    }

    /**
     * Delete the given company
     * @param  Request  $request
     * @param  Company  $company
     * @return RedirectResponse
     */
    public function destroy(Request $request, Company $company): RedirectResponse
    {
        app(DeleteCompany::class)->delete($request->user(), $company, $request->all());

        return redirect()->route('companies.index');
    }
}
