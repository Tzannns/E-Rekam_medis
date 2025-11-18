<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pasien\StoreProfilPasienRequest;
use App\Http\Requests\Pasien\UpdateProfilPasienRequest;
use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function create(): View
    {
        return view('pasien.profil.create');
    }

    public function store(StoreProfilPasienRequest $request): RedirectResponse
    {
        $user = Auth::user();

        Pasien::create([
            'user_id' => $user->id,
            'nik' => $request->input('nik'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp'),
        ]);

        return redirect()->route('pasien.dashboard')->with('success', 'Profil pasien berhasil dibuat.');
    }

    public function edit(): View
    {
        $pasien = Auth::user()->pasien;
        if (! $pasien) {
            return view('pasien.profil.create');
        }

        return view('pasien.profil.edit', compact('pasien'));
    }

    public function update(UpdateProfilPasienRequest $request): RedirectResponse
    {
        $pasien = Auth::user()->pasien;
        if (! $pasien) {
            return redirect()->route('pasien.profil.create');
        }

        $pasien->update([
            'nik' => $request->input('nik'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp'),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profil pasien berhasil diperbarui.');
    }
}
