<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePetugasRequest;
use App\Http\Requests\Admin\UpdatePetugasRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class PetugasController extends Controller
{
    public function index(): View
    {
        $petugasRole = Role::where('name', 'Petugas')->first();
        $petugas = User::role('Petugas')->latest()->paginate(15);

        return view('admin.petugas.index', compact('petugas'));
    }

    public function create(): View
    {
        return view('admin.petugas.create');
    }

    public function store(StorePetugasRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Petugas');

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil ditambahkan');
    }

    public function show(User $petuga): View
    {
        // Ensure user has Petugas role
        if (! $petuga->hasRole('Petugas')) {
            abort(404);
        }

        return view('admin.petugas.show', compact('petuga'));
    }

    public function edit(User $petuga): View
    {
        // Ensure user has Petugas role
        if (! $petuga->hasRole('Petugas')) {
            abort(404);
        }

        return view('admin.petugas.edit', compact('petuga'));
    }

    public function update(UpdatePetugasRequest $request, User $petuga): RedirectResponse
    {
        // Ensure user has Petugas role
        if (! $petuga->hasRole('Petugas')) {
            abort(404);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petuga->update($data);

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui');
    }

    public function destroy(User $petuga): RedirectResponse
    {
        // Ensure user has Petugas role
        if (! $petuga->hasRole('Petugas')) {
            abort(404);
        }

        if (auth()->id() === $petuga->id) {
            return back()->with('warning', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $petuga->delete();

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil dihapus');
    }
}
