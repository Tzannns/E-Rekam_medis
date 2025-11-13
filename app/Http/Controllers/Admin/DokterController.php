<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDokterRequest;
use App\Http\Requests\Admin\UpdateDokterRequest;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DokterController extends Controller
{
    public function index(): View
    {
        $dokter = Dokter::with('user')->latest()->paginate(15);

        return view('admin.dokter.index', compact('dokter'));
    }

    public function create(): View
    {
        return view('admin.dokter.create');
    }

    public function store(StoreDokterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Dokter');

        Dokter::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'spesialisasi' => $request->spesialisasi,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()
            ->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan');
    }

    public function show(Dokter $dokter): View
    {
        $dokter->load('user');

        return view('admin.dokter.show', compact('dokter'));
    }

    public function edit(Dokter $dokter): View
    {
        $dokter->load('user');

        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(UpdateDokterRequest $request, Dokter $dokter): RedirectResponse
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $dokter->user->update($data);

        $dokter->update([
            'nip' => $request->nip,
            'spesialisasi' => $request->spesialisasi,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()
            ->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui');
    }

    public function destroy(Dokter $dokter): RedirectResponse
    {
        if (auth()->id() === $dokter->user_id) {
            return back()->with('warning', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $dokter->user->delete();

        return redirect()
            ->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil dihapus');
    }
}
