<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;


class PermissionController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('viewAny', Permission::class);

        $permission_list = Permission::paginate(config('app.defaults.pagination'));

        return Inertia::render('Permissions/Index', compact('permission_list'));
    }

    public function create(Request $request): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('create', Permission::class);

        return Inertia::render('Permissions/Create');
    }

    public function edit(Request $request, Permission $permission): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('edit', $permission);

        return Inertia::render('Permissions/Edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('edit', $permission);

        $validated = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id
        ]);

        $permission->update($validated);

        return redirect()->route('permissions.index');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('create', Permission::class);

        $validated = $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create($validated);

        return redirect()->route('permissions.index');
    }

    public function destroy(Request $request, Permission $permission): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('destroy', $permission);

        $permission->delete();

        return redirect()->route('permissions.index');
    }
}
