<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PendaftaranController extends Controller
{
    /**
     * Tampilkan dashboard pendaftaran untuk Petugas.
     */
    public function index(): View
    {
        $totalPasien = Pasien::count();
        $pendaftaranBulanIni = Pasien::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $totalDokter = Dokter::count();
        $pasienTerbaru = Pasien::latest('created_at')->take(5)->get();

        return view('petugas.pendaftaran.index', compact(
            'totalPasien',
            'pendaftaranBulanIni',
            'totalDokter',
            'pasienTerbaru'
        ));
    }

    public function create(): View
    {
        return view('petugas.pendaftaran.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $nik = trim($request->input('nik', ''));

        $nikError = null;
        if (empty($nik)) {
            $nikError = 'NIK harus diisi';
        } elseif (strlen($nik) !== 16) {
            $nikError = 'NIK harus terdiri dari 16 digit';
        } elseif (! ctype_digit($nik)) {
            $nikError = 'NIK hanya boleh berisi angka';
        } elseif (Pasien::where('nik', $nik)->exists()) {
            $nikError = 'NIK sudah terdaftar dalam sistem';
        }

        $data = $request->all();
        $data['nik'] = $nik;

        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'nik' => 'required',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.string' => 'Nama harus berupa teks',
            'nama.max' => 'Nama maksimal 255 karakter',
            'alamat.required' => 'Alamat harus diisi',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid',
        ]);

        if ($nikError) {
            $validator->errors()->add('nik', $nikError);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->nama,
                'email' => $nik.'@pasien.local',
                'password' => bcrypt('password'),
            ]);

            $user->assignRole('Pasien');

            Pasien::create([
                'user_id' => $user->id,
                'nik' => $nik,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telp' => $request->no_telp,
            ]);

            return redirect()->route('petugas.pendaftaran.index')->with('success', 'Pasien berhasil didaftarkan ke sistem');
        } catch (\Exception $e) {
            if (isset($user)) {
                $user->delete();
            }

            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: '.$e->getMessage()])
                ->withInput();
        }
    }
}
