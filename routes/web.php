<?php

use App\Http\Controllers\Admin\ApotikController;
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
use App\Http\Controllers\Pasien\DashboardController as PasienDashboardController;
use App\Http\Controllers\Pasien\DokterController as PasienDokterController;
use App\Http\Controllers\Pasien\JadwalController as PasienJadwalController;
use App\Http\Controllers\Pasien\PoliController as PasienPoliController;
use App\Http\Controllers\Pasien\RekamMedisController as PasienRekamMedisController;
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

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rekam Medis
    Route::resource('rekam-medis', RekamMedisController::class)->middleware('permission:rekam-medis.view');
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
    Route::get('/storage', [StorageController::class, 'index'])->name('storage.index');
    Route::get('/apotik', [ApotikController::class, 'index'])->name('apotik.index');
    Route::get('/laboratorium', [LaboratoriumController::class, 'index'])->name('laboratorium.index');
    Route::get('/radiologi', [RadiologiController::class, 'index'])->name('radiologi.index');
    Route::get('/manajemen', [ManajemenController::class, 'index'])->name('manajemen.index');
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

    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])
        ->name('rekam-medis.index')
        ->middleware('permission:rekam-medis.view');

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

    Route::get('/apotik', [ApotikController::class, 'index'])
        ->name('apotik.index')
        ->middleware('permission:apotik.view');

    Route::get('/laboratorium', [LaboratoriumController::class, 'index'])
        ->name('laboratorium.index')
        ->middleware('permission:laboratorium.view');

    Route::get('/radiologi', [RadiologiController::class, 'index'])
        ->name('radiologi.index')
        ->middleware('permission:radiologi.view');

    Route::get('/gizi', [GiziController::class, 'index'])
        ->name('gizi.index')
        ->middleware('permission:gizi.view');

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
});

require __DIR__.'/auth.php';
