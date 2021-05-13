<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserCompanyController extends Controller
{
    public function store(Request $request, User $user): RedirectResponse
    {
        $user->companies()->syncWithoutDetaching($request->company_id);
        return redirect()->back();
    }
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->companies()->detach($request->company_id);
        return redirect()->back();
    }
}
