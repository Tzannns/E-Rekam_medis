<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserManagementRequest;
use App\Http\Requests\Admin\UpdateUserManagementRequest;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with(['roles', 'dokter', 'pasien']);

        // Search functionality
        if ($request->filled('pencarian')) {
            $search = $request->pencarian;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role') && $request->role !== 'semua') {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by status (active/inactive) - optional
        if ($request->filled('status') && $request->status !== 'semua') {
            $isActive = $request->status === 'aktif';
            $query->where('is_active', $isActive);
        }

        $users = $query->latest()->paginate(15);
        $users->appends($request->query());

        return view('admin.user-management.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.user-management.create');
    }

    public function store(StoreUserManagementRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        // Create related records for Dokter and Pasien roles
        if ($request->role === 'Dokter') {
            Dokter::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'spesialisasi' => $request->spesialisasi,
                'no_telp' => $request->no_telp,
            ]);
        } elseif ($request->role === 'Pasien') {
            Pasien::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ]);
        }

        return redirect()
            ->route('admin.user-management.index')
            ->with('success', 'Data user berhasil ditambahkan');
    }

    public function show(User $user): View
    {
        $user->load(['roles', 'dokter', 'pasien']);

        return view('admin.user-management.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $user->load(['roles', 'dokter', 'pasien']);

        return view('admin.user-management.edit', compact('user'));
    }

    public function update(UpdateUserManagementRequest $request, User $user): RedirectResponse
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Update related dokter data if exists
        if ($user->dokter) {
            $user->dokter->update([
                'nip' => $request->nip ?? $user->dokter->nip,
                'spesialisasi' => $request->spesialisasi ?? $user->dokter->spesialisasi,
                'no_telp' => $request->no_telp ?? $user->dokter->no_telp,
            ]);
        }

        // Update related pasien data if exists
        if ($user->pasien) {
            $user->pasien->update([
                'nik' => $request->nik ?? $user->pasien->nik,
                'tanggal_lahir' => $request->tanggal_lahir ?? $user->pasien->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin ?? $user->pasien->jenis_kelamin,
                'alamat' => $request->alamat ?? $user->pasien->alamat,
                'no_telp' => $request->no_telp ?? $user->pasien->no_telp,
            ]);
        }

        return redirect()
            ->route('admin.user-management.index')
            ->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('warning', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.user-management.index')
            ->with('success', 'Data user berhasil dihapus');
    }

    public function export(Request $request): Response
    {
        $query = User::with(['roles', 'dokter', 'pasien']);

        // Search functionality
        if ($request->filled('pencarian')) {
            $search = $request->pencarian;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role') && $request->role !== 'semua') {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->latest()->get();

        $pdf = Pdf::loadView('admin.user-management.export-pdf', compact('users'));

        return $pdf->download('data-users-'.now()->format('d-m-Y-H-i-s').'.pdf');
    }
}
