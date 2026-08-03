<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $users = User::with('roles')->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.users', compact('users', 'roles'));
    }

    public function store(StoreAdminUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->assignRole($data['role']);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function roles(): View
    {
        $this->authorize('viewAny', User::class);

        $roles = Role::with('permissions')->orderBy('name')->get();

        return view('admin.roles', compact('roles'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate(['role' => 'required|string|exists:roles,name']);

        $user = User::findOrFail($id);
        $user->syncRoles([$request->input('role')]);

        return redirect()->route('admin.users.index')->with('success', 'User role updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        /** @var User $user */
        User::destroy($user->getKey());

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
