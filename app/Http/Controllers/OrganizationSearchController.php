<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganizationSearchController extends Controller
{
    public function index(Request $request)
    {
        $organizations = Organization::search($request->search)->paginate(15);

        return Inertia::render('Organizations/Index', compact('organizations'));
    }
}
