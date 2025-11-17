<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pengaturan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ManajemenController extends Controller
{
    /**
     * Display dashboard manajemen
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'total_activities' => LogAktivitas::count(),
            'recent_activities' => LogAktivitas::with('user')->latest('waktu')->limit(10)->get(),
        ];

        return view('admin.manajemen.index', compact('stats'));
    }

    /**
     * Pengaturan Aplikasi
     */
    public function pengaturan(): View
    {
        $pengaturan = Pengaturan::getSettings();
        return view('admin.manajemen.pengaturan', compact('pengaturan'));
    }

    /**
     * Update pengaturan aplikasi
     */
    public function updatePengaturan(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'timezone' => 'required|string|max:50',
            'bahasa' => 'required|in:id,en',
            'tema' => 'required|in:light,dark',
            'items_per_page' => 'required|integer|min:5|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:512',
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'nullable|string',
            'registrasi_pasien' => 'boolean',
            'antrian_online' => 'boolean',
        ]);

        try {
            $pengaturan = Pengaturan::getSettings();
            $data = $request->except(['logo', 'favicon']);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Hapus logo lama
                if ($pengaturan->logo && Storage::exists('public/' . $pengaturan->logo)) {
                    Storage::delete('public/' . $pengaturan->logo);
                }
                
                $logoPath = $request->file('logo')->store('settings', 'public');
                $data['logo'] = $logoPath;
            }

            // Handle favicon upload
            if ($request->hasFile('favicon')) {
                // Hapus favicon lama
                if ($pengaturan->favicon && Storage::exists('public/' . $pengaturan->favicon)) {
                    Storage::delete('public/' . $pengaturan->favicon);
                }
                
                $faviconPath = $request->file('favicon')->store('settings', 'public');
                $data['favicon'] = $faviconPath;
            }

            $pengaturan->update($data);

            // Log aktivitas
            LogAktivitas::log('Update pengaturan aplikasi', 'manajemen', 'update');

            return redirect()->back()->with('success', 'Pengaturan aplikasi berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Manajemen User
     */
    public function users(): View
    {
        $users = User::with('roles')->latest()->paginate(20);
        $roles = Role::all();
        return view('admin.manajemen.users', compact('users', 'roles'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
            ]);

            $user->assignRole($request->role);

            // Log aktivitas
            LogAktivitas::log('Membuat user baru: ' . $user->name, 'manajemen', 'create');

            return redirect()->back()->with('success', 'User berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            $user->syncRoles([$request->role]);

            // Log aktivitas
            LogAktivitas::log('Update user: ' . $user->name, 'manajemen', 'update');

            return redirect()->back()->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user): RedirectResponse
    {
        try {
            if ($user->id === auth()->id()) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus user yang sedang login');
            }

            $userName = $user->name;
            $user->delete();

            // Log aktivitas
            LogAktivitas::log('Menghapus user: ' . $userName, 'manajemen', 'delete');

            return redirect()->back()->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Manajemen Role & Permissions
     */
    public function roles(): View
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.manajemen.roles', compact('roles', 'permissions'));
    }

    /**
     * Store new role
     */
    public function storeRole(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        try {
            $role = Role::create(['name' => $request->name]);
            
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            // Log aktivitas
            LogAktivitas::log('Membuat role baru: ' . $role->name, 'manajemen', 'create');

            return redirect()->back()->with('success', 'Role berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update role
     */
    public function updateRole(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        try {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions ?? []);

            // Log aktivitas
            LogAktivitas::log('Update role: ' . $role->name, 'manajemen', 'update');

            return redirect()->back()->with('success', 'Role berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete role
     */
    public function destroyRole(Role $role): RedirectResponse
    {
        try {
            if ($role->users()->count() > 0) {
                return redirect()->back()->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh user');
            }

            $roleName = $role->name;
            $role->delete();

            // Log aktivitas
            LogAktivitas::log('Menghapus role: ' . $roleName, 'manajemen', 'delete');

            return redirect()->back()->with('success', 'Role berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Log Aktivitas
     */
    public function logAktivitas(): View
    {
        $logs = LogAktivitas::with('user')
            ->latest('waktu')
            ->paginate(30);

        return view('admin.manajemen.log-aktivitas', compact('logs'));
    }

    /**
     * Clear log aktivitas
     */
    public function clearLog(): RedirectResponse
    {
        try {
            LogAktivitas::truncate();
            
            // Log aktivitas
            LogAktivitas::log('Membersihkan log aktivitas', 'manajemen', 'clear');

            return redirect()->back()->with('success', 'Log aktivitas berhasil dibersihkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Backup Database
     */
    public function backup(): View
    {
        $backups = collect();
        $backupPath = storage_path('app/backups');
        
        if (File::exists($backupPath)) {
            $files = File::files($backupPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'sql') {
                    $backups->push([
                        'name' => $file->getFilename(),
                        'size' => $this->formatBytes($file->getSize()),
                        'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                        'path' => $file->getPathname(),
                    ]);
                }
            }
        }

        $backups = $backups->sortByDesc('created_at');

        return view('admin.manajemen.backup', compact('backups'));
    }

    /**
     * Create database backup
     */
    public function createBackup(): RedirectResponse
    {
        try {
            $backupPath = storage_path('app/backups');
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $filePath = $backupPath . '/' . $filename;

            // Get database connection info
            $dbHost = config('database.connections.mysql.host');
            $dbPort = config('database.connections.mysql.port');
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');

            // Create backup command
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s',
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbUser),
                escapeshellarg($dbPass),
                escapeshellarg($dbName),
                escapeshellarg($filePath)
            );

            // Execute backup
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception('Backup gagal dijalankan');
            }

            // Log aktivitas
            LogAktivitas::log('Membuat backup database: ' . $filename, 'manajemen', 'backup');

            return redirect()->back()->with('success', 'Backup database berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Download backup file
     */
    public function downloadBackup($filename)
    {
        try {
            $backupPath = storage_path('app/backups/' . $filename);
            
            if (!File::exists($backupPath)) {
                return redirect()->back()->with('error', 'File backup tidak ditemukan');
            }

            // Log aktivitas
            LogAktivitas::log('Download backup database: ' . $filename, 'manajemen', 'download');

            return response()->download($backupPath);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete backup file
     */
    public function deleteBackup($filename): RedirectResponse
    {
        try {
            $backupPath = storage_path('app/backups/' . $filename);
            
            if (!File::exists($backupPath)) {
                return redirect()->back()->with('error', 'File backup tidak ditemukan');
            }

            File::delete($backupPath);

            // Log aktivitas
            LogAktivitas::log('Menghapus backup database: ' . $filename, 'manajemen', 'delete');

            return redirect()->back()->with('success', 'Backup berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
