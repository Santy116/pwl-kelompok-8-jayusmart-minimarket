<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $authUser = $request->user();

        $users = User::with(['branch', 'roles'])
            ->when(! $authUser->hasRole('owner'), function ($query) use ($authUser) {
                $query->where('branch_id', $authUser->branch_id)
                    ->whereDoesntHave('roles', function ($query) {
                        $query->where('name', 'owner');
                    });
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->role($role);
            })
            ->when($authUser->hasRole('owner') && $request->branch_id, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', [
            'users' => $users,
            'roles' => $this->availableRoles($authUser),
            'branches' => $this->availableBranches($authUser),
        ]);
    }

    public function create(Request $request): View
    {
        $authUser = $request->user();

        return view('users.create', [
            'roles' => $this->availableRoles($authUser),
            'branches' => $this->availableBranches($authUser),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $authUser = $request->user();

        if (! $authUser->hasRole('owner')) {
            $validated['branch_id'] = $authUser->branch_id;

            if (! in_array($validated['role'], ['supervisor', 'cashier', 'warehouse'], true)) {
                abort(403);
            }
        }

        $user = User::create([
            'branch_id' => $validated['branch_id'] ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(Request $request, User $user): View
    {
        $this->authorizeUserAccess($request, $user);

        $authUser = $request->user();

        $user->load(['branch', 'roles']);

        return view('users.edit', [
            'user' => $user,
            'roles' => $this->availableRoles($authUser),
            'branches' => $this->availableBranches($authUser),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorizeUserAccess($request, $user);

        $validated = $request->validated();
        $authUser = $request->user();

        if (! $authUser->hasRole('owner')) {
            $validated['branch_id'] = $authUser->branch_id;

            if (! in_array($validated['role'], ['supervisor', 'cashier', 'warehouse'], true)) {
                abort(403);
            }
        }

        $data = [
            'branch_id' => $validated['branch_id'] ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorizeUserAccess($request, $user);

        if ($request->user()->id === $user->id) {
            return redirect()
                ->route('users.index')
                ->with('error', 'User yang sedang login tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    private function authorizeUserAccess(Request $request, User $user): void
    {
        $authUser = $request->user();

        if ($authUser->hasRole('owner')) {
            return;
        }

        if ($user->branch_id !== $authUser->branch_id || $user->hasRole('owner')) {
            abort(403);
        }
    }

    private function availableRoles(User $authUser)
    {
        if ($authUser->hasRole('owner')) {
            return Role::orderBy('name')->get();
        }

        return Role::whereIn('name', [
            'supervisor',
            'cashier',
            'warehouse',
        ])->orderBy('name')->get();
    }

    private function availableBranches(User $authUser)
    {
        if ($authUser->hasRole('owner')) {
            return Branch::orderBy('name')->get();
        }

        return Branch::where('id', $authUser->branch_id)->get();
    }
}
