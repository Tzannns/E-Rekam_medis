<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePasienRequest;
use App\Http\Requests\Admin\UpdatePasienRequest;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PasienController extends Controller
{
    public function index(): View
    {
        $pasien = Pasien::with('user')->latest()->paginate(15);

        return view('admin.pasien.index', compact('pasien'));
    }

    public function create(): View
    {
        return view('admin.pasien.create');
    }

    public function store(StorePasienRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Pasien');

        Pasien::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function show(Pasien $pasien): View
    {
        $pasien->load('user');

        return view('admin.pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien): View
    {
        $pasien->load('user');

        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(UpdatePasienRequest $request, Pasien $pasien): RedirectResponse
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pasien->user->update($data);

        $pasien->update([
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    public function destroy(Pasien $pasien): RedirectResponse
    {
        if (auth()->id() === $pasien->user_id) {
            return back()->with('warning', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $pasien->user->delete();

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil dihapus');
    }
}
