<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserCompanyController extends Controller
{
    public function store(Request $request, User $user): RedirectResponse
    {
        if (! $request->user()->hasPermissionTo('attach companies')) {
            abort(403);
        }

        $request->validate([
            'company_id' => 'required|exists:companies,id'
        ]);

        $user->companies()->syncWithoutDetaching($request->company_id);
        return redirect()->back();
    }
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if (! $request->user()->hasPermissionTo('detach companies')) {
            abort(403);
        }

        $request->validate([
            'company_id' => 'required|exists:companies,id'
        ]);

        $user->companies()->detach($request->company_id);
        return redirect()->back();
    }
}
