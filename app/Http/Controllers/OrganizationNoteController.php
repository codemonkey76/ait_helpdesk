<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class OrganizationNoteController extends Controller
{
    /**
     * @return InertiaResponse
     */
    public function create(): InertiaResponse
    {
        return Inertia::render('Notes/Create');
    }
}
