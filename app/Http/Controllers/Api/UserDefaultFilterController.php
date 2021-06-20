<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserDefaultFilterController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'filters'           => 'required',
            'filters.pending' => 'required|boolean',
            'filters.open'    => 'required|boolean',
            'filters.waiting' => 'required|boolean',
            'filters.billing' => 'required|boolean',
            'filters.closed'  => 'required|boolean',
            'filters.others' => 'required|boolean'
        ]);
        $request->user()->update(['filters' => $validated['filters']]);

        return redirect()->back();
    }
}
