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
use App\Http\Controllers\Admin\RadiologiController;
use App\Http\Controllers\Admin\RawatInapController;
use App\Http\Controllers\Admin\RawatJalanController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Admin\StorageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Dokter\DashboardController as DokterDashboardController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Dokter\IGDController as DokterIGDController;
use App\Http\Controllers\Dokter\JadwalController as DokterJadwalController;
use App\Http\Controllers\Dokter\LaboratoriumController as DokterLaboratoriumController;
use App\Http\Controllers\Dokter\PasienController as DokterPasienController;
use App\Http\Controllers\Dokter\RadiologiController as DokterRadiologiController;
use App\Http\Controllers\Dokter\RawatInapController as DokterRawatInapController;
use App\Http\Controllers\Dokter\RawatJalanController as DokterRawatJalanController;
use App\Http\Controllers\Dokter\RekamMedisController as DokterRekamMedisController;
use App\Http\Controllers\Pasien\DashboardController as PasienDashboardController;
use App\Http\Controllers\Pasien\DokterController as PasienDokterController;
use App\Http\Controllers\Pasien\JadwalController as PasienJadwalController;
use App\Http\Controllers\Pasien\RekamMedisController as PasienRekamMedisController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

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

    // Users (simplified - can be expanded)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Dokter (simplified - can be expanded)
    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');

    // Pasien (simplified - can be expanded)
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');

    // Modul Admin
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index')->middleware('permission:pendaftaran.view');
    Route::get('/igd', [IGDController::class, 'index'])->name('igd.index');
    Route::get('/rawat-jalan', [RawatJalanController::class, 'index'])->name('rawat-jalan.index');
    Route::get('/rawat-inap', [RawatInapController::class, 'index'])->name('rawat-inap.index');
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::get('/storage', [StorageController::class, 'index'])->name('storage.index');
    Route::get('/apotik', [ApotikController::class, 'index'])->name('apotik.index');
    Route::get('/laboratorium', [LaboratoriumController::class, 'index'])->name('laboratorium.index');
    Route::get('/radiologi', [RadiologiController::class, 'index'])->name('radiologi.index');
    Route::get('/manajemen', [ManajemenController::class, 'index'])->name('manajemen.index');
    Route::get('/gizi', [GiziController::class, 'index'])->name('gizi.index');
    Route::get('/laundry', [LaundryController::class, 'index'])->name('laundry.index');
});

// Dokter Routes
Route::middleware(['auth', 'role:Dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rekam-medis', [DokterRekamMedisController::class, 'index'])->name('rekam-medis.index');
    Route::get('/rekam-medis/create', [DokterRekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('/rekam-medis', [DokterRekamMedisController::class, 'store'])->name('rekam-medis.store');
    Route::get('/rekam-medis/{rekamMedi}', [DokterRekamMedisController::class, 'show'])->name('rekam-medis.show');

    // Modul Dokter
    Route::get('/igd', [DokterIGDController::class, 'index'])->name('igd.index');
    Route::get('/rawat-jalan', [DokterRawatJalanController::class, 'index'])->name('rawat-jalan.index');
    Route::get('/rawat-inap', [DokterRawatInapController::class, 'index'])->name('rawat-inap.index');
    Route::get('/pasien', [DokterPasienController::class, 'index'])->name('pasien.index');
    Route::get('/laboratorium', [DokterLaboratoriumController::class, 'index'])->name('laboratorium.index');
    Route::get('/radiologi', [DokterRadiologiController::class, 'index'])->name('radiologi.index');
    Route::get('/jadwal', [DokterJadwalController::class, 'index'])->name('jadwal.index');
});

// Petugas Routes
Route::middleware(['auth', 'role:Petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');

    // Akses modul untuk Petugas (dengan permission)
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])
        ->name('pendaftaran.index')
        ->middleware('permission:pendaftaran.view');

    Route::get('/rawat-jalan', [RawatJalanController::class, 'index'])
        ->name('rawat-jalan.index')
        ->middleware('permission:rawat-jalan.view');

    Route::get('/rawat-inap', [RawatInapController::class, 'index'])
        ->name('rawat-inap.index')
        ->middleware('permission:rawat-inap.view');

    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])
        ->name('rekam-medis.index')
        ->middleware('permission:rekam-medis.view');

    Route::get('/igd', [IGDController::class, 'index'])
        ->name('igd.index')
        ->middleware('permission:igd.view');

    Route::get('/kasir', [KasirController::class, 'index'])
        ->name('kasir.index')
        ->middleware('permission:kasir.view');

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
});

// Pasien Routes
Route::middleware(['auth', 'role:Pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rekam-medis', [PasienRekamMedisController::class, 'index'])->name('rekam-medis.index');
    Route::get('/rekam-medis/{rekamMedi}', [PasienRekamMedisController::class, 'show'])->name('rekam-medis.show');

    // Modul Pasien
    Route::get('/jadwal', [PasienJadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/dokter', [PasienDokterController::class, 'index'])->name('dokter.index');

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
