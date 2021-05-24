<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CompanyNoteController extends Controller
{
    public function create(): InertiaResponse
    {
        return Inertia::render('Notes/Create');
    }
}
