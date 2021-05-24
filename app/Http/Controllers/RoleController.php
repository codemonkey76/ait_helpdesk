<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class RoleController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('viewAny', Role::class);

        $roles = Role::paginate(config('app.defaults.pagination'));
        return Inertia::render('Roles/Index', compact('roles'));
    }

    public function create(Request $request): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('create', Role::class);

        return Inertia::render('Roles/Create');
    }

    public function store(Request $request)
    {
        Gate::forUser($request->user())->authorize('create', Role::class);

        $validated = $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create($validated);

        return redirect()->route('roles.index');
    }

    public function edit(Request $request, Role $role): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('edit', $role);

        $permission_list = Permission::all();
        $role->load('permissions');
        return Inertia::render('Roles/Edit', compact('role', 'permission_list'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('edit', $role);

        $validated = $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id
        ]);

        $role->update($validated);

        return redirect()->route('roles.index');
    }

}
