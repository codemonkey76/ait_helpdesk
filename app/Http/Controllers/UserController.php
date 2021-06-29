<?php

namespace App\Http\Controllers;


use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Laravel\Jetstream\Contracts\DeletesUsers;

class UserController extends Controller
{
    /**
     * List the users.
     *
     * @param  Request  $request
     * @return InertiaResponse
     * @throws AuthorizationException
     */
    public function index(Request $request): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('viewAny', User::class);

        if ($request->has('q')) {
            $users = User::search($request->q)->paginate(15);
        } else {
            $users = User::orderBy('name')->paginate(15);
        }

        $q = $request->q;
        return Inertia::render('Users/Index', compact('users', 'q'));
    }

    public function show(Request $request, User $user): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('view', $user);


        return Inertia::render('Users/Show', [
            'targetUser' => $user
        ]);
    }

    public function edit(Request $request, User $user): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('edit', $user);

        $companies = Company::all()->groupBy(fn($company) =>
            (string) Str::of($company->name)
                ->limit(1, '')
                ->ucfirst()
            );

        $availableRoles = Role::all();

        return Inertia::render('Users/Edit', [
            'targetUser' => $user->load('companies'),
            'companies' => $companies,
            'availableRoles' => $availableRoles
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        $creator = app(DeletesUsers::class);

        $creator->delete($user);

        return redirect()->route('users.index');
    }
}
