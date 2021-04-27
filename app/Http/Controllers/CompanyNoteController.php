<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyNoteController extends Controller
{
    public function create()
    {
        return Inertia::render('Notes/Create');
    }
}
