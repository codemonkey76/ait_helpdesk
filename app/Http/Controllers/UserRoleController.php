<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function store(Request $request, User $user): RedirectResponse
    {
        $user->roles()->syncWithoutDetaching($request->role_id);
        return redirect()->back();
    }
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->roles()->detach($request->role_id);
        return redirect()->back();
    }
}
