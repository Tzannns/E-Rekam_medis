<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with('roles')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'semua') {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->paginate(15);
        $roles = \Spatie\Permission\Models\Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create(): View
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data user berhasil ditambahkan');
    }

    public function show(User $user): View
    {
        $user->load('roles');

        return view('admin.users.show', compact('user'));
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
        $roles = Role::all();
        $userRoleNames = $user->roles->pluck('name')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'userRoleNames'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('warning', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data user berhasil dihapus');
    }
}
