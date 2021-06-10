<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TestController extends Controller
{
    public function test(Request $request): InertiaResponse
    {
        return Inertia::render('Tests/TestForm');
    }

    public function store(Request $request)
    {
        $prefs = [];
        $validated = $request->validate([
            'sms_pref' => 'required|boolean',
            'email_pref' => 'required|boolean'
        ]);
        if ($validated['sms_pref']) {
            array_push($prefs, 'sms');
        }

        if ($validated['email_pref']) {
            array_push($prefs, 'email');
        }

        dd($prefs);

        return redirect()->route('test.form');
    }
}
