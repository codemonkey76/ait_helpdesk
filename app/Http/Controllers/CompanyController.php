<?php

namespace App\Http\Controllers;

use App\Actions\Companies\CreateCompany;
use App\Actions\Companies\DeleteCompany;
use App\Actions\Companies\UpdateCompany;
use App\Models\Company;
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
        $companies = Company::paginate(15);

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
        return Inertia::render('Companies/Show', compact('company'));
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
        $request->validate([
            'password' => 'required|string|password',
        ]);

        app(DeleteCompany::class)->delete($company);

        return redirect()->route('companies.index');
    }
}
