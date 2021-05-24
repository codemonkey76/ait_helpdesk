<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    public function store(Request $request, Role $role): RedirectResponse
    {
        if (!$request->user()->hasPermissionTo('attach permissions')) {
            abort(403);
        }

        $request->validate([
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $permission = Permission::find($request->permission_id);
        $role->givePermissionTo($permission);

        return redirect()->route('roles.edit', $role->id);
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        if (!$request->user()->hasPermissionTo('detach permissions')) {
            abort(403);
        }

        $request->validate([
            'permission_id' => 'required|exists:permissions,id'
        ]);
        $permission = Permission::find($request->permission_id);
        $role->revokePermissionTo($permission);

        return redirect()->route('roles.edit', $role->id);
    }
}
