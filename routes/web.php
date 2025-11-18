<?php

use App\Http\Controllers\Admin\ApotikController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\GiziController;
use App\Http\Controllers\Admin\IGDController;
use App\Http\Controllers\Admin\KasirController;
use App\Http\Controllers\Admin\LaboratoriumController;
use App\Http\Controllers\Admin\LaundryController;
use App\Http\Controllers\Admin\ManajemenController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\RadiologiController;
use App\Http\Controllers\Admin\RawatInapController;
use App\Http\Controllers\Admin\RawatJalanController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Admin\StorageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Dokter\DashboardController as DokterDashboardController;
use App\Http\Controllers\Dokter\IGDController as DokterIGDController;
use App\Http\Controllers\Dokter\JadwalController as DokterJadwalController;
use App\Http\Controllers\Dokter\LaboratoriumController as DokterLaboratoriumController;
use App\Http\Controllers\Dokter\PasienController as DokterPasienController;
use App\Http\Controllers\Dokter\PoliController as DokterPoliController;
use App\Http\Controllers\Dokter\RadiologiController as DokterRadiologiController;
use App\Http\Controllers\Dokter\RawatInapController as DokterRawatInapController;
use App\Http\Controllers\Dokter\RawatJalanController as DokterRawatJalanController;
use App\Http\Controllers\Dokter\RekamMedisController as DokterRekamMedisController;
use App\Http\Controllers\Pasien\AppointmentController as PasienAppointmentController;
use App\Http\Controllers\Pasien\DashboardController as PasienDashboardController;
use App\Http\Controllers\Pasien\DokterController as PasienDokterController;
use App\Http\Controllers\Pasien\JadwalController as PasienJadwalController;
use App\Http\Controllers\Pasien\PoliController as PasienPoliController;
use App\Http\Controllers\Pasien\RekamMedisController as PasienRekamMedisController;
use App\Http\Controllers\Petugas\AppointmentController as PetugasAppointmentController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\IGDController as PetugasIGDController;
use App\Http\Controllers\Petugas\PendaftaranController as PetugasPendaftaranController;
use App\Http\Controllers\Petugas\PoliController as PetugasPoliController;
use App\Http\Controllers\Petugas\RawatJalanController as PetugasRawatJalanController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    /** @var User $user */
    $user = Auth::user();

    if ($user->hasRole('Admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('Dokter')) {
        return redirect()->route('dokter.dashboard');
    }

    if ($user->hasRole('Petugas')) {
        return redirect()->route('petugas.dashboard');
    }

    if ($user->hasRole('Pasien')) {
        return redirect()->route('pasien.dashboard');
    }

    // Fallback: jika user tidak punya role, assign role Pasien dan redirect
    $user->assignRole('Pasien');

    return redirect()->route('pasien.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Test route outside middleware
Route::get('/test-route', function () {
    $user = auth()->user();
    $hasRole = $user->hasRole('Admin');
    $roles = $user->getRoleNames();

    return 'User: '.$user->email.'<br>Has Admin Role: '.($hasRole ? 'YES' : 'NO').'<br>Roles: '.$roles->implode(', ');
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rekam Medis
    Route::resource('rekam-medis', RekamMedisController::class)
        ->parameters(['rekam-medis' => 'rekamMedi'])
        ->middleware('permission:rekam-medis.view');
    Route::get('/rekam-medis-data', [RekamMedisController::class, 'data'])->name('rekam-medis.data');

    // Users Resource Routes
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('users', UserController::class)->except(['index']);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Dokter Resource Routes
    Route::resource('dokter', DokterController::class);

    // Pasien Resource Routes
    Route::resource('pasien', PasienController::class);

    // Poli Resource Routes
    Route::resource('poli', PoliController::class);

    // Petugas Resource Routes
    Route::resource('petugas', PetugasController::class);

    // User Management Resource Routes (Unified User, Pasien, Dokter, Petugas)
    Route::resource('user-management', UserManagementController::class)->parameters(['user-management' => 'user'])->middleware('permission:users.view');
    Route::get('user-management-export', [UserManagementController::class, 'export'])->name('user-management.export')->middleware('permission:users.view');

    // Modul Admin
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index')->middleware('permission:pendaftaran.view');
    Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // IGD Resource Routes
    Route::resource('igd', IGDController::class)->middleware('permission:igd.view');

    // Rawat Jalan Resource Routes
    Route::resource('rawat-jalan', RawatJalanController::class)->middleware('permission:rawat-jalan.view');

    // Rawat Inap Resource Routes
    Route::resource('rawat-inap', RawatInapController::class)->middleware('permission:rawat-inap.view');
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index')->middleware('permission:kasir.view');
    Route::get('/kasir/create', [KasirController::class, 'create'])->name('kasir.create')->middleware('permission:kasir.create');
    Route::post('/kasir', [KasirController::class, 'store'])->name('kasir.store')->middleware('permission:kasir.create');
    Route::get('/kasir/{kasir}', [KasirController::class, 'show'])->name('kasir.show')->middleware('permission:kasir.view');
    Route::post('/kasir/{kasir}/pembayaran', [KasirController::class, 'tambahPembayaran'])->name('kasir.pembayaran.store')->middleware('permission:kasir.create');
    Route::resource('storage', StorageController::class)->middleware('permission:storage.view');

    // Apotik Sub-modules - HARUS DI ATAS resource apotik
    Route::prefix('apotik')->name('apotik.')->group(function () {
        Route::resource('supplier', \App\Http\Controllers\Admin\SupplierController::class);
        Route::resource('obat', \App\Http\Controllers\Admin\ObatController::class);
        Route::resource('stok', \App\Http\Controllers\Admin\StokObatController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('transaksi', \App\Http\Controllers\Admin\TransaksiApotikController::class);
    });

    // Resource apotik HARUS DI BAWAH agar tidak menangkap /apotik/supplier dll
    Route::resource('apotik', ApotikController::class)->middleware('permission:apotik.view');

    Route::get('/laboratorium', [LaboratoriumController::class, 'index'])->name('laboratorium.index')->middleware('permission:laboratorium.view');
    Route::get('/laboratorium/create', [LaboratoriumController::class, 'create'])->name('laboratorium.create')->middleware('permission:laboratorium.create');
    Route::post('/laboratorium', [LaboratoriumController::class, 'store'])->name('laboratorium.store')->middleware('permission:laboratorium.create');
    Route::get('/laboratorium/{laboratorium}', [LaboratoriumController::class, 'show'])->name('laboratorium.show')->middleware('permission:laboratorium.view');
    Route::get('/laboratorium/{laboratorium}/edit', [LaboratoriumController::class, 'edit'])->name('laboratorium.edit')->middleware('permission:laboratorium.edit');
    Route::put('/laboratorium/{laboratorium}', [LaboratoriumController::class, 'update'])->name('laboratorium.update')->middleware('permission:laboratorium.edit');
    Route::delete('/laboratorium/{laboratorium}', [LaboratoriumController::class, 'destroy'])->name('laboratorium.destroy')->middleware('permission:laboratorium.delete');
    Route::get('/radiologi', [RadiologiController::class, 'index'])->name('radiologi.index')->middleware('permission:radiologi.view');
    Route::get('/radiologi/create', [RadiologiController::class, 'create'])->name('radiologi.create')->middleware('permission:radiologi.create');
    Route::post('/radiologi', [RadiologiController::class, 'store'])->name('radiologi.store')->middleware('permission:radiologi.create');
    Route::get('/radiologi/{radiologi}', [RadiologiController::class, 'show'])->name('radiologi.show')->middleware('permission:radiologi.view');
    Route::get('/radiologi/{radiologi}/edit', [RadiologiController::class, 'edit'])->name('radiologi.edit')->middleware('permission:radiologi.edit');
    Route::put('/radiologi/{radiologi}', [RadiologiController::class, 'update'])->name('radiologi.update')->middleware('permission:radiologi.edit');
    Route::delete('/radiologi/{radiologi}', [RadiologiController::class, 'destroy'])->name('radiologi.destroy')->middleware('permission:radiologi.delete');
    Route::get('/manajemen', [ManajemenController::class, 'index'])->name('manajemen.index');

    // Pengaturan Aplikasi
    Route::get('/manajemen/pengaturan', [ManajemenController::class, 'pengaturan'])->name('manajemen.pengaturan');
    Route::post('/manajemen/pengaturan', [ManajemenController::class, 'updatePengaturan'])->name('manajemen.update-pengaturan');

    // Manajemen User
    Route::get('/manajemen/users', [ManajemenController::class, 'users'])->name('manajemen.users');
    Route::post('/manajemen/users', [ManajemenController::class, 'storeUser'])->name('manajemen.store-user');
    Route::put('/manajemen/users/{user}', [ManajemenController::class, 'updateUser'])->name('manajemen.update-user');
    Route::delete('/manajemen/users/{user}', [ManajemenController::class, 'destroyUser'])->name('manajemen.destroy-user');

    // Manajemen Role
    Route::get('/manajemen/roles', [ManajemenController::class, 'roles'])->name('manajemen.roles');
    Route::post('/manajemen/roles', [ManajemenController::class, 'storeRole'])->name('manajemen.store-role');
    Route::put('/manajemen/roles/{role}', [ManajemenController::class, 'updateRole'])->name('manajemen.update-role');
    Route::delete('/manajemen/roles/{role}', [ManajemenController::class, 'destroyRole'])->name('manajemen.destroy-role');

    // Log Aktivitas
    Route::get('/manajemen/log-aktivitas', [ManajemenController::class, 'logAktivitas'])->name('manajemen.log-aktivitas');
    Route::delete('/manajemen/log-aktivitas/clear', [ManajemenController::class, 'clearLog'])->name('manajemen.clear-log');

    // Backup Database
    Route::get('/manajemen/backup', [ManajemenController::class, 'backup'])->name('manajemen.backup');
    Route::post('/manajemen/backup/create', [ManajemenController::class, 'createBackup'])->name('manajemen.create-backup');
    Route::get('/manajemen/backup/download/{filename}', [ManajemenController::class, 'downloadBackup'])->name('manajemen.download-backup');
    Route::delete('/manajemen/backup/delete/{filename}', [ManajemenController::class, 'deleteBackup'])->name('manajemen.delete-backup');
    Route::get('/gizi', [GiziController::class, 'index'])
        ->name('gizi.index')
        ->middleware('permission:gizi.view');
    Route::get('/gizi/create', [GiziController::class, 'create'])
        ->name('gizi.create')
        ->middleware('permission:gizi.create');
    Route::post('/gizi', [GiziController::class, 'store'])
        ->name('gizi.store')
        ->middleware('permission:gizi.create');
    Route::get('/gizi/{gizi}', [GiziController::class, 'show'])
        ->name('gizi.show')
        ->middleware('permission:gizi.view');
    Route::get('/gizi/{gizi}/edit', [GiziController::class, 'edit'])
        ->name('gizi.edit')
        ->middleware('permission:gizi.edit');
    Route::put('/gizi/{gizi}', [GiziController::class, 'update'])
        ->name('gizi.update')
        ->middleware('permission:gizi.edit');
    Route::delete('/gizi/{gizi}', [GiziController::class, 'destroy'])
        ->name('gizi.destroy')
        ->middleware('permission:gizi.delete');
    Route::get('/laundry', [LaundryController::class, 'index'])
        ->name('laundry.index')
        ->middleware('permission:laundry.view');
    Route::get('/laundry/create', [LaundryController::class, 'create'])
        ->name('laundry.create')
        ->middleware('permission:laundry.create');
    Route::post('/laundry', [LaundryController::class, 'store'])
        ->name('laundry.store')
        ->middleware('permission:laundry.create');
    Route::get('/laundry/{laundry}', [LaundryController::class, 'show'])
        ->name('laundry.show')
        ->middleware('permission:laundry.view');
    Route::get('/laundry/{laundry}/edit', [LaundryController::class, 'edit'])
        ->name('laundry.edit')
        ->middleware('permission:laundry.edit');
    Route::put('/laundry/{laundry}', [LaundryController::class, 'update'])
        ->name('laundry.update')
        ->middleware('permission:laundry.edit');
    Route::delete('/laundry/{laundry}', [LaundryController::class, 'destroy'])
        ->name('laundry.destroy')
        ->middleware('permission:laundry.delete');

    // Appointment moderation
    Route::get('/appointment', [AdminAppointmentController::class, 'index'])
        ->name('appointment.index')
        ->middleware('permission:appointment.view');
    Route::get('/appointment/{appointment}', [AdminAppointmentController::class, 'show'])
        ->name('appointment.show')
        ->middleware('permission:appointment.view');
    Route::put('/appointment/{appointment}', [AdminAppointmentController::class, 'update'])
        ->name('appointment.update')
        ->middleware('permission:appointment.edit');
});

// Dokter Routes
Route::middleware(['auth', 'role:Dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rekam-medis', [DokterRekamMedisController::class, 'index'])->name('rekam-medis.index');
    Route::get('/rekam-medis/create', [DokterRekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('/rekam-medis', [DokterRekamMedisController::class, 'store'])->name('rekam-medis.store');
    Route::get('/rekam-medis/{rekamMedi}', [DokterRekamMedisController::class, 'show'])->name('rekam-medis.show');

    // Modul Dokter
    Route::get('/igd', [DokterIGDController::class, 'index'])
        ->name('igd.index')
        ->middleware('permission:igd.view');
    Route::get('/igd/{igd}', [DokterIGDController::class, 'show'])
        ->name('igd.show')
        ->middleware('permission:igd.view');
    Route::get('/igd/{igd}/edit', [DokterIGDController::class, 'edit'])
        ->name('igd.edit')
        ->middleware('permission:igd.edit');
    Route::put('/igd/{igd}', [DokterIGDController::class, 'update'])
        ->name('igd.update')
        ->middleware('permission:igd.edit');
    Route::get('/rawat-jalan', [DokterRawatJalanController::class, 'index'])
        ->name('rawat-jalan.index')
        ->middleware('permission:rawat-jalan.view');
    Route::get('/rawat-jalan/{rawatJalan}', [DokterRawatJalanController::class, 'show'])
        ->name('rawat-jalan.show')
        ->middleware('permission:rawat-jalan.view');
    Route::get('/rawat-jalan/{rawatJalan}/edit', [DokterRawatJalanController::class, 'edit'])
        ->name('rawat-jalan.edit')
        ->middleware('permission:rawat-jalan.edit');
    Route::put('/rawat-jalan/{rawatJalan}', [DokterRawatJalanController::class, 'update'])
        ->name('rawat-jalan.update')
        ->middleware('permission:rawat-jalan.edit');
    Route::get('/rawat-inap', [DokterRawatInapController::class, 'index'])->name('rawat-inap.index');
    Route::get('/pasien', [DokterPasienController::class, 'index'])->name('pasien.index');
    Route::get('/laboratorium', [DokterLaboratoriumController::class, 'index'])->name('laboratorium.index');
    Route::get('/radiologi', [DokterRadiologiController::class, 'index'])->name('radiologi.index');
    Route::get('/jadwal', [DokterJadwalController::class, 'index'])->name('jadwal.index');

    // Poli Routes
    Route::get('/poli', [DokterPoliController::class, 'index'])->name('poli.index');
    Route::get('/poli/{poli}', [DokterPoliController::class, 'show'])->name('poli.show');
});

// Petugas Routes
Route::middleware(['auth', 'role:Petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');

    // Akses modul untuk Petugas (dengan permission)
    Route::get('/pendaftaran', [PetugasPendaftaranController::class, 'index'])
        ->name('pendaftaran.index')
        ->middleware('permission:pendaftaran.view');
    Route::get('/pendaftaran/create', [PetugasPendaftaranController::class, 'create'])
        ->name('pendaftaran.create')
        ->middleware('permission:pendaftaran.create');
    Route::post('/pendaftaran', [PetugasPendaftaranController::class, 'store'])
        ->name('pendaftaran.store')
        ->middleware('permission:pendaftaran.create');

    Route::get('/rawat-jalan', [PetugasRawatJalanController::class, 'index'])
        ->name('rawat-jalan.index')
        ->middleware('permission:rawat-jalan.view');
    Route::get('/rawat-jalan/create', [PetugasRawatJalanController::class, 'create'])
        ->name('rawat-jalan.create')
        ->middleware('permission:rawat-jalan.create');
    Route::post('/rawat-jalan', [PetugasRawatJalanController::class, 'store'])
        ->name('rawat-jalan.store')
        ->middleware('permission:rawat-jalan.create');
    Route::get('/rawat-jalan/{rawatJalan}', [PetugasRawatJalanController::class, 'show'])
        ->name('rawat-jalan.show')
        ->middleware('permission:rawat-jalan.view');
    Route::get('/rawat-jalan/{rawatJalan}/edit', [PetugasRawatJalanController::class, 'edit'])
        ->name('rawat-jalan.edit')
        ->middleware('permission:rawat-jalan.edit');
    Route::put('/rawat-jalan/{rawatJalan}', [PetugasRawatJalanController::class, 'update'])
        ->name('rawat-jalan.update')
        ->middleware('permission:rawat-jalan.edit');
    Route::delete('/rawat-jalan/{rawatJalan}', [PetugasRawatJalanController::class, 'destroy'])
        ->name('rawat-jalan.destroy')
        ->middleware('permission:rawat-jalan.delete');

    Route::get('/rawat-inap', [RawatInapController::class, 'index'])
        ->name('rawat-inap.index')
        ->middleware('permission:rawat-inap.view');
    Route::get('/rawat-inap/create', [RawatInapController::class, 'create'])
        ->name('rawat-inap.create')
        ->middleware('permission:rawat-inap.create');
    Route::post('/rawat-inap', [RawatInapController::class, 'store'])
        ->name('rawat-inap.store')
        ->middleware('permission:rawat-inap.create');
    Route::get('/rawat-inap/{rawatInap}', [RawatInapController::class, 'show'])
        ->name('rawat-inap.show')
        ->middleware('permission:rawat-inap.view');
    Route::get('/rawat-inap/{rawatInap}/edit', [RawatInapController::class, 'edit'])
        ->name('rawat-inap.edit')
        ->middleware('permission:rawat-inap.edit');
    Route::put('/rawat-inap/{rawatInap}', [RawatInapController::class, 'update'])
        ->name('rawat-inap.update')
        ->middleware('permission:rawat-inap.edit');
    Route::delete('/rawat-inap/{rawatInap}', [RawatInapController::class, 'destroy'])
        ->name('rawat-inap.destroy')
        ->middleware('permission:rawat-inap.delete');

    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])
        ->name('rekam-medis.index')
        ->middleware('permission:rekam-medis.view');
    Route::get('/rekam-medis/create', [RekamMedisController::class, 'create'])
        ->name('rekam-medis.create')
        ->middleware('permission:rekam-medis.create');
    Route::post('/rekam-medis', [RekamMedisController::class, 'store'])
        ->name('rekam-medis.store')
        ->middleware('permission:rekam-medis.create');
    Route::get('/rekam-medis/{rekamMedi}', [RekamMedisController::class, 'show'])
        ->name('rekam-medis.show')
        ->middleware('permission:rekam-medis.view');
    Route::get('/rekam-medis/{rekamMedi}/edit', [RekamMedisController::class, 'edit'])
        ->name('rekam-medis.edit')
        ->middleware('permission:rekam-medis.edit');
    Route::put('/rekam-medis/{rekamMedi}', [RekamMedisController::class, 'update'])
        ->name('rekam-medis.update')
        ->middleware('permission:rekam-medis.edit');
    Route::delete('/rekam-medis/{rekamMedi}', [RekamMedisController::class, 'destroy'])
        ->name('rekam-medis.destroy')
        ->middleware('permission:rekam-medis.delete');

    // Poli Routes
    Route::get('/poli', [PetugasPoliController::class, 'index'])->name('poli.index');
    Route::get('/poli/{poli}', [PetugasPoliController::class, 'show'])->name('poli.show');

    Route::get('/igd', [PetugasIGDController::class, 'index'])
        ->name('igd.index')
        ->middleware('permission:igd.view');
    Route::get('/igd/create', [PetugasIGDController::class, 'create'])
        ->name('igd.create')
        ->middleware('permission:igd.create');
    Route::post('/igd', [PetugasIGDController::class, 'store'])
        ->name('igd.store')
        ->middleware('permission:igd.create');
    Route::get('/igd/{igd}', [PetugasIGDController::class, 'show'])
        ->name('igd.show')
        ->middleware('permission:igd.view');
    Route::get('/igd/{igd}/edit', [PetugasIGDController::class, 'edit'])
        ->name('igd.edit')
        ->middleware('permission:igd.edit');
    Route::put('/igd/{igd}', [PetugasIGDController::class, 'update'])
        ->name('igd.update')
        ->middleware('permission:igd.edit');
    Route::delete('/igd/{igd}', [PetugasIGDController::class, 'destroy'])
        ->name('igd.destroy')
        ->middleware('permission:igd.delete');

    Route::get('/kasir', [KasirController::class, 'index'])
        ->name('kasir.index')
        ->middleware('permission:kasir.view');
    Route::get('/kasir/create', [KasirController::class, 'create'])
        ->name('kasir.create')
        ->middleware('permission:kasir.create');
    Route::post('/kasir', [KasirController::class, 'store'])
        ->name('kasir.store')
        ->middleware('permission:kasir.create');
    Route::get('/kasir/{kasir}', [KasirController::class, 'show'])
        ->name('kasir.show')
        ->middleware('permission:kasir.view');
    Route::post('/kasir/{kasir}/pembayaran', [KasirController::class, 'tambahPembayaran'])
        ->name('kasir.pembayaran.store')
        ->middleware('permission:kasir.create');

    Route::get('/storage', [StorageController::class, 'index'])
        ->name('storage.index')
        ->middleware('permission:storage.view');
    Route::get('/storage/create', [StorageController::class, 'create'])
        ->name('storage.create')
        ->middleware('permission:storage.create');
    Route::post('/storage', [StorageController::class, 'store'])
        ->name('storage.store')
        ->middleware('permission:storage.create');
    Route::get('/storage/{storageItem}', [StorageController::class, 'show'])
        ->name('storage.show')
        ->middleware('permission:storage.view');
    Route::get('/storage/{storageItem}/edit', [StorageController::class, 'edit'])
        ->name('storage.edit')
        ->middleware('permission:storage.edit');
    Route::put('/storage/{storageItem}', [StorageController::class, 'update'])
        ->name('storage.update')
        ->middleware('permission:storage.edit');
    Route::delete('/storage/{storageItem}', [StorageController::class, 'destroy'])
        ->name('storage.destroy')
        ->middleware('permission:storage.delete');

    Route::get('/apotik', [ApotikController::class, 'index'])
        ->name('apotik.index')
        ->middleware('permission:apotik.view');
    Route::get('/apotik/create', [ApotikController::class, 'create'])
        ->name('apotik.create')
        ->middleware('permission:apotik.create');
    Route::post('/apotik', [ApotikController::class, 'store'])
        ->name('apotik.store')
        ->middleware('permission:apotik.create');
    Route::get('/apotik/{apotik}', [ApotikController::class, 'show'])
        ->name('apotik.show')
        ->middleware('permission:apotik.view');
    Route::get('/apotik/{apotik}/edit', [ApotikController::class, 'edit'])
        ->name('apotik.edit')
        ->middleware('permission:apotik.edit');
    Route::put('/apotik/{apotik}', [ApotikController::class, 'update'])
        ->name('apotik.update')
        ->middleware('permission:apotik.edit');
    Route::delete('/apotik/{apotik}', [ApotikController::class, 'destroy'])
        ->name('apotik.destroy')
        ->middleware('permission:apotik.delete');

    // Appointment moderation (Petugas)
    Route::get('/appointment', [PetugasAppointmentController::class, 'index'])
        ->name('appointment.index')
        ->middleware('permission:appointment.view');
    Route::get('/appointment/{appointment}', [PetugasAppointmentController::class, 'show'])
        ->name('appointment.show')
        ->middleware('permission:appointment.view');
    Route::put('/appointment/{appointment}', [PetugasAppointmentController::class, 'update'])
        ->name('appointment.update')
        ->middleware('permission:appointment.edit');

    Route::get('/laboratorium', [LaboratoriumController::class, 'index'])
        ->name('laboratorium.index')
        ->middleware('permission:laboratorium.view');
    Route::get('/laboratorium/create', [LaboratoriumController::class, 'create'])
        ->name('laboratorium.create')
        ->middleware('permission:laboratorium.create');
    Route::post('/laboratorium', [LaboratoriumController::class, 'store'])
        ->name('laboratorium.store')
        ->middleware('permission:laboratorium.create');
    Route::get('/laboratorium/{laboratorium}', [LaboratoriumController::class, 'show'])
        ->name('laboratorium.show')
        ->middleware('permission:laboratorium.view');
    Route::get('/laboratorium/{laboratorium}/edit', [LaboratoriumController::class, 'edit'])
        ->name('laboratorium.edit')
        ->middleware('permission:laboratorium.edit');
    Route::put('/laboratorium/{laboratorium}', [LaboratoriumController::class, 'update'])
        ->name('laboratorium.update')
        ->middleware('permission:laboratorium.edit');
    Route::delete('/laboratorium/{laboratorium}', [LaboratoriumController::class, 'destroy'])
        ->name('laboratorium.destroy')
        ->middleware('permission:laboratorium.delete');

    Route::get('/radiologi', [RadiologiController::class, 'index'])
        ->name('radiologi.index')
        ->middleware('permission:radiologi.view');
    Route::get('/radiologi/create', [RadiologiController::class, 'create'])
        ->name('radiologi.create')
        ->middleware('permission:radiologi.create');
    Route::post('/radiologi', [RadiologiController::class, 'store'])
        ->name('radiologi.store')
        ->middleware('permission:radiologi.create');
    Route::get('/radiologi/{radiologi}', [RadiologiController::class, 'show'])
        ->name('radiologi.show')
        ->middleware('permission:radiologi.view');
    Route::get('/radiologi/{radiologi}/edit', [RadiologiController::class, 'edit'])
        ->name('radiologi.edit')
        ->middleware('permission:radiologi.edit');
    Route::put('/radiologi/{radiologi}', [RadiologiController::class, 'update'])
        ->name('radiologi.update')
        ->middleware('permission:radiologi.edit');
    Route::delete('/radiologi/{radiologi}', [RadiologiController::class, 'destroy'])
        ->name('radiologi.destroy')
        ->middleware('permission:radiologi.delete');

    Route::get('/gizi', [GiziController::class, 'index'])
        ->name('gizi.index')
        ->middleware('permission:gizi.view');
    Route::get('/gizi/create', [GiziController::class, 'create'])
        ->name('gizi.create')
        ->middleware('permission:gizi.create');
    Route::post('/gizi', [GiziController::class, 'store'])
        ->name('gizi.store')
        ->middleware('permission:gizi.create');
    Route::get('/gizi/{gizi}', [GiziController::class, 'show'])
        ->name('gizi.show')
        ->middleware('permission:gizi.view');
    Route::get('/gizi/{gizi}/edit', [GiziController::class, 'edit'])
        ->name('gizi.edit')
        ->middleware('permission:gizi.edit');
    Route::put('/gizi/{gizi}', [GiziController::class, 'update'])
        ->name('gizi.update')
        ->middleware('permission:gizi.edit');
    Route::delete('/gizi/{gizi}', [GiziController::class, 'destroy'])
        ->name('gizi.destroy')
        ->middleware('permission:gizi.delete');

    Route::get('/laundry', [LaundryController::class, 'index'])
        ->name('laundry.index')
        ->middleware('permission:laundry.view');
    Route::get('/laundry/create', [LaundryController::class, 'create'])
        ->name('laundry.create')
        ->middleware('permission:laundry.create');
    Route::post('/laundry', [LaundryController::class, 'store'])
        ->name('laundry.store')
        ->middleware('permission:laundry.create');
    Route::get('/laundry/{laundry}', [LaundryController::class, 'show'])
        ->name('laundry.show')
        ->middleware('permission:laundry.view');
    Route::get('/laundry/{laundry}/edit', [LaundryController::class, 'edit'])
        ->name('laundry.edit')
        ->middleware('permission:laundry.edit');
    Route::put('/laundry/{laundry}', [LaundryController::class, 'update'])
        ->name('laundry.update')
        ->middleware('permission:laundry.edit');
    Route::delete('/laundry/{laundry}', [LaundryController::class, 'destroy'])
        ->name('laundry.destroy')
        ->middleware('permission:laundry.delete');
});

// Pasien Routes
Route::middleware(['auth', 'role:Pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rekam-medis', [PasienRekamMedisController::class, 'index'])->name('rekam-medis.index');
    Route::get('/rekam-medis/{rekamMedi}', [PasienRekamMedisController::class, 'show'])->name('rekam-medis.show');

    // Modul Pasien
    Route::get('/jadwal', [PasienJadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/appointment', [PasienAppointmentController::class, 'index'])->name('appointment.index');
    Route::get('/appointment/create', [PasienAppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [PasienAppointmentController::class, 'store'])->name('appointment.store');
    Route::put('/appointment/{appointment}/cancel', [PasienAppointmentController::class, 'cancel'])->name('appointment.cancel');
    Route::get('/dokter', [PasienDokterController::class, 'index'])->name('dokter.index');

    // Poli Routes
    Route::get('/poli', [PasienPoliController::class, 'index'])->name('poli.index');
    Route::get('/poli/{poli}', [PasienPoliController::class, 'show'])->name('poli.show');

    // Profil Pasien
    Route::get('/profil/create', [\App\Http\Controllers\Pasien\ProfilController::class, 'create'])->name('profil.create');
    Route::post('/profil', [\App\Http\Controllers\Pasien\ProfilController::class, 'store'])->name('profil.store');
    Route::get('/profil/edit', [\App\Http\Controllers\Pasien\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [\App\Http\Controllers\Pasien\ProfilController::class, 'update'])->name('profil.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/api/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
});

require __DIR__.'/auth.php';

// Test notification (hapus di production)
Route::get('/test-notification', function () {
    $user = auth()->user();
    
    if (!$user) {
        return 'Please login first';
    }

    // Buat notifikasi dummy
    $user->notify(new \App\Notifications\AppointmentReminder(
        \App\Models\Appointment::first() ?? new \App\Models\Appointment([
            'poli_id' => 1,
            'nomor_antrian' => 1,
            'tanggal_usulan' => now(),
            'jam_usulan' => '08:00',
        ])
    ));

    return redirect()->route('notifications.index')->with('success', 'Notifikasi test berhasil dibuat!');
})->middleware('auth');
