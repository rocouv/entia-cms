<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreUserRequest;
use App\Http\Requests\Dashboard\UpdateUserRequest;
use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('dashboard.users.index', [
            'users' => User::query()
                ->with('role')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::query()->create([
            ...$request->validated(),
            'role_id' => $this->editorRole()->id,
            'site_id' => $request->user()->site_id ?? Site::query()->value('id'),
        ]);

        return to_route('dashboard.users.index')->with('status', 'Editor creado correctamente.');
    }

    public function edit(User $user): View
    {
        return view('dashboard.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        return to_route('dashboard.users.index')->with('status', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->ensureEditor($user);

        $user->delete();

        return to_route('dashboard.users.index')->with('status', 'Editor eliminado correctamente.');
    }

    private function editorRole(): Role
    {
        return Role::query()->where('slug', Role::EDITOR)->firstOrFail();
    }

    private function ensureEditor(User $user): void
    {
        abort_unless($user->hasRole(Role::EDITOR), 403);
    }
}
