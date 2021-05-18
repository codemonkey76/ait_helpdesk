<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PhoneVerificationPromptController extends Controller
{
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedPhone()
            ? redirect()->intended(config('fortify.home'))
            : Inertia::render('Phone/Verify');
    }
}
