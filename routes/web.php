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

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/

// Metrics (Prometheus exporter)
Route::get('/metrics', [MetricsController::class, 'index']);

// Login routes
Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/sesi', [LoginController::class, 'index'])->name('sesi'); // custom login route
    Route::post('/sesi/login', [LoginController::class, 'login'])->name('login.post');
    Route::view('/branding', 'layouts.branding');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isLogin'])->group(function () {

    // Signup (Admin registration)
    Route::get('/sesi/signup', [LoginController::class, 'create'])->name('signup');
    Route::post('/sesi', [LoginController::class, 'store'])->name('signup.post');

    /*
    |--------------------------------------------------------------------------
    | TAMU Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('tamu')->group(function () {
        Route::get('/', [TamusController::class, 'index'])->name('tamu');
        Route::post('/', [TamusController::class, 'store'])->name('tamu.store');
        Route::get('/create', [TamusController::class, 'create'])->name('tamu.create');
        Route::post('/import', [TamusController::class, 'importExcel'])->name('tamu.import');

        // Path routes under tamu
        Route::prefix('path')->group(function () {
            Route::get('/', [PathController::class, 'indexPath'])->name('path');
            Route::get('/create', [PathController::class, 'createPath'])->name('path.create');
            Route::post('/', [PathController::class, 'storePath'])->name('path.store');
            Route::delete('/{id}', [PathController::class, 'destroy'])->name('path.delete');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Mahasiswa Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('mahasiswa')->group(function () {
        Route::get('/', [MahasiswasController::class, 'index'])->name('mahasiswa');
        Route::get('/create', [MahasiswasController::class, 'create'])->name('mahasiswa.create');
    });

    Route::prefix('datamahasiswa')->group(function () {
        Route::get('/', [DatamahasiswaController::class, 'index'])->name('datamahasiswa');
        Route::get('/create', [DatamahasiswaController::class, 'create'])->name('datamahasiswa.create');
        Route::post('/', [DatamahasiswaController::class, 'store'])->name('datamahasiswa.store');
        Route::post('/import', [DatamahasiswaController::class, 'importExcel'])->name('datamahasiswa.import');
        Route::delete('/{id_mahasiswa}', [DatamahasiswaController::class, 'destroy'])->name('datamahasiswa.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Jadwal Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('jadwal')->group(function () {
        Route::get('/', [JadwalController::class, 'index'])->name('jadwal');
        Route::get('/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::delete('/{id_kelas}', [JadwalController::class, 'destroy'])->name('jadwal.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Storage Route
    |--------------------------------------------------------------------------
    */
    Route::get('/storage', [StorageController::class, 'index'])->name('storage');

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->group(function () {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('profile');
        Route::patch('/{id}', [ProfileController::class, 'update'])->name('profile.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Home (Dashboard)
    |--------------------------------------------------------------------------
    */
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/*
|--------------------------------------------------------------------------
| Default Laravel Auth Routes
|--------------------------------------------------------------------------
*/
Auth::routes(); // Optional, for Laravel UI/Breeze/etc
