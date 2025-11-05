<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('roles')->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

        public function data(Request $request): JsonResponse
        {
            $query = User::with('roles')->select('users.*');

            return DataTables::eloquent($query)
                ->addColumn('roles', function (User $user) {
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->addColumn('actions', function (User $user) {
                    return view('admin.users.partials.actions', compact('user'))->render();
                })
                ->rawColumns(['actions'])
                ->toJson();
        }

        public function edit(User $user): View
        {
            $roles = Role::all()->pluck('name', 'id');
            $userRoleNames = $user->roles->pluck('name')->toArray();

            return view('admin.users.edit', compact('user', 'roles', 'userRoleNames'));
        }

        public function update(Request $request, User $user): RedirectResponse
        {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
                'roles' => ['nullable', 'array'],
                'roles.*' => ['string']
            ]);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $roleNames = $validated['roles'] ?? [];
            $user->syncRoles($roleNames);

            return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
        }

        public function destroy(User $user): RedirectResponse
        {
            // Hindari menghapus diri sendiri saat ini
            if (auth()->id() === $user->id) {
                return back()->with('warning', 'Anda tidak dapat menghapus akun Anda sendiri.');
            }

            $user->delete();

            return back()->with('success', 'User berhasil dihapus.');
        }
}
