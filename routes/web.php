<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Metrics\MetricsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TamusController;
use App\Http\Controllers\PathController;
use App\Http\Controllers\MahasiswasController;
use App\Http\Controllers\DatamahasiswaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// ============================
// METRICS
// ============================
Route::get('/metrics', [MetricsController::class, 'index']);

// ============================
// AUTH ROUTES
// ============================
Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Logout route (POST method)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================
// PUBLIC ROUTES (GUEST ONLY)
// ============================
Route::middleware('guest')->group(function() {
    // Ganti name 'login' menjadi 'sesi'
    Route::get('/sesi', [LoginController::class, 'index'])->name('sesi'); // Nama route diubah
    Route::post('/sesi/login', [LoginController::class, 'login'])->name('login.post');
    Route::view('/branding', 'layouts.branding');
});

// ============================
// PROTECTED ROUTES (AUTH ONLY)
// ============================
Route::middleware(['auth', 'isLogin'])->group(function() {

    // AUTH ROUTES
    Route::get('/sesi/signup', [LoginController::class, 'create'])->name('register');
    Route::post('/sesi', [LoginController::class, 'store'])->name('register');

    // TAMU ROUTES
    Route::prefix('tamu')->group(function() {
        Route::get('/', [TamusController::class, 'index'])->name('tamu');
        Route::post('/', [TamusController::class, 'store'])->name('tamu.store');
        Route::get('/create', [TamusController::class, 'create'])->name('tamu.create');

        // PATH TAMU ROUTES
        Route::prefix('path')->group(function() {
            Route::get('/', [PathController::class, 'indexPath'])->name('path');
            Route::get('/create', [PathController::class, 'createPath'])->name('path.create');
            Route::post('/', [PathController::class, 'storePath'])->name('path.store');
            Route::delete('{id}', [PathController::class, 'destroy'])->name('path.delete');
        });
    });

    // MAHASISWA ROUTES
    Route::prefix('mahasiswa')->group(function() {
        Route::get('/', [MahasiswasController::class, 'index'])->name('mahasiswa');
        Route::get('/create', [MahasiswasController::class, 'create'])->name('mahasiswa.create');
    });

    // DATA MAHASISWA ROUTES
    Route::prefix('datamahasiswa')->group(function() {
        Route::get('/', [DatamahasiswaController::class, 'index'])->name('datamahasiswa');
        Route::get('/create', [DatamahasiswaController::class, 'create'])->name('datamahasiswa.create');
        Route::post('/', [DatamahasiswaController::class, 'store'])->name('datamahasiswa.store');
        Route::delete('{id_mahasiswa}', [DatamahasiswaController::class, 'destroy'])->name('datamahasiswa.delete');
    });

    // JADWAL ROUTES
    Route::prefix('jadwal')->group(function() {
        Route::get('/', [JadwalController::class, 'index'])->name('jadwal');
        Route::get('/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::delete('{id_kelas}', [JadwalController::class, 'destroy'])->name('jadwal.delete');
    });

    // ADMIN ROUTES
    Route::get('/storage', [StorageController::class, 'index'])->name('storage');

    // PROFILE ROUTES
    Route::prefix('profile')->group(function() {
        Route::get('{id}', [ProfileController::class, 'index'])->name('profile');
        Route::patch('{id}', [ProfileController::class, 'update'])->name('profile.update');
    });

    // DEFAULT LARAVEL ROUTES
    Auth::routes();
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
