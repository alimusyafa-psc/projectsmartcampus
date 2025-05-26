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

Route::get('/metrics', [MetricsController::class, 'index']);
Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/sesi', [LoginController::class, 'index'])->name('sesi');
    Route::post('/sesi/login', [LoginController::class, 'login'])->name('login.post');
    Route::view('/branding', 'layouts.branding');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (auth & isLogin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isLogin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN Only - Sign Up
    |--------------------------------------------------------------------------
    */
    Route::get('/sesi/signup', [LoginController::class, 'create'])->name('signup');
    Route::post('/sesi', [LoginController::class, 'store'])->name('signup.post');

    /*
    |--------------------------------------------------------------------------
    | Storage (All Roles)
    |--------------------------------------------------------------------------
    */
    Route::get('/storage', [StorageController::class, 'index'])->name('storage');

    /*
    |--------------------------------------------------------------------------
    | Profile (All Roles)
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('index');
        Route::patch('/{id}', [ProfileController::class, 'update'])->name('update');
    });

    /*
    |--------------------------------------------------------------------------
    | TAMU + ADMIN Roles
    |--------------------------------------------------------------------------
    */
    Route::prefix('tamu')->name('tamu.')->group(function () {
        Route::get('/', [TamusController::class, 'index'])->name('index');
        Route::get('/create', [TamusController::class, 'create'])->name('create');
        Route::post('/', [TamusController::class, 'store'])->name('store');
        Route::post('/import', [TamusController::class, 'importExcel'])->name('import');

        // Path (child of tamu)
        Route::prefix('path')->name('path.')->group(function () {
            Route::get('/', [PathController::class, 'indexPath'])->name('index');
            Route::get('/create', [PathController::class, 'createPath'])->name('create');
            Route::post('/', [PathController::class, 'storePath'])->name('store');
            Route::delete('/{id}', [PathController::class, 'destroy'])->name('delete');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | MAHASISWA + ADMIN Roles
    |--------------------------------------------------------------------------
    */
    Route::prefix('datamahasiswa')->name('datamahasiswa.')->group(function () {
        Route::get('/', [DatamahasiswaController::class, 'index'])->name('index');
        Route::get('/create', [DatamahasiswaController::class, 'create'])->name('create');
        Route::post('/', [DatamahasiswaController::class, 'store'])->name('store');
        Route::post('/import', [DatamahasiswaController::class, 'importExcel'])->name('import');
        Route::delete('/{id_mahasiswa}', [DatamahasiswaController::class, 'destroy'])->name('delete');
    });

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/', [MahasiswasController::class, 'index'])->name('index');
        Route::get('/create', [MahasiswasController::class, 'create'])->name('create');
    });

    Route::prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', [JadwalController::class, 'index'])->name('index');
        Route::get('/create', [JadwalController::class, 'create'])->name('create');
        Route::post('/', [JadwalController::class, 'store'])->name('store');
        Route::delete('/{id_kelas}', [JadwalController::class, 'destroy'])->name('delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Home / Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/*
|--------------------------------------------------------------------------
| Default Laravel Auth Routes (Optional)
|--------------------------------------------------------------------------
*/
Auth::routes();
