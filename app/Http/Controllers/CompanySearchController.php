<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanySearchController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::search($request->search)->paginate(15);

        return Inertia::render( 'Companies/Index', compact('companies'));
    }
}
