<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Metrics\MetricsController;

Route::get('/metrics', [MetricsController::class, 'index']);
Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::get('/', [\App\Http\Controllers\LoginController::class, 'index']);
// Logout harus method POST
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// Public routes (accessible without authentication)
Route::middleware('guest')->group(function () {
    Route::get('/sesi', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('/sesi/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
    Route::get('/branding', function () {
        return view('layouts.branding'); // Perhatikan path 'layout.profiles'
    });
});

// Protected routes (require authentication)
Route::middleware(['auth', 'isLogin'])->group(function () {
    // Application routes
    Route::get('/sesi/signup', [\App\Http\Controllers\LoginController::class, 'create'])->name('register');
    Route::post('/sesi', [\App\Http\Controllers\LoginController::class, 'store'])->name('register');

    //TAMU
    Route::get('/tamu', [\App\Http\Controllers\TamusController::class, 'index'])->name('tamu');
    Route::post('/tamu', [\App\Http\Controllers\TamusController::class, 'store'])->name('tamu');
    Route::get('/tamu/create', [\App\Http\Controllers\TamusController::class, 'create'])->name('tamu');
    // Upload Excel (form + submit)
    Route::post('/tamu/import', [\App\Http\Controllers\TamusController::class, 'importExcel'])->name('tamu.import');
    Route::get('/tamu/path', [\App\Http\Controllers\PathController::class, 'indexPath'])->name('path');
    Route::get('/tamu/path/create', [\App\Http\Controllers\PathController::class, 'createPath'])->name('path');
    Route::post('/tamu/path', [\App\Http\Controllers\PathController::class, 'storePath'])->name('path');
    Route::get('/tamu/path/{id}/edit', [\App\Http\Controllers\PathController::class, 'editPath'])->name('path.edit');
    Route::put('/tamu/path/{id}', [\App\Http\Controllers\PathController::class, 'updatePath'])->name('path.update');


    //MAHASISWA
    Route::get('/mahasiswa', [\App\Http\Controllers\MahasiswasController::class, 'index'])->name('mahasiswa');
    Route::get('/mahasiswa/create', [\App\Http\Controllers\MahasiswasController::class, 'create'])->name('mahasiswa');
    Route::get('/datamahasiswa', [\App\Http\Controllers\DatamahasiswaController::class, 'index'])->name('datamahasiswa');
    Route::get('/datamahasiswa/create', [\App\Http\Controllers\DatamahasiswaController::class, 'create'])->name('datamahasiswa');
    Route::post('/datamahasiswa', [\App\Http\Controllers\DatamahasiswaController::class, 'store'])->name('datamahasiswa');
    Route::delete('/datamahasiswa/{id_mahasiswa}', [\App\Http\Controllers\DatamahasiswaController::class, 'destroy'])->name('datamahasiswa');
    // Upload Excel (form + submit)
    Route::post('/datamahasiswa/import', [\App\Http\Controllers\DatamahasiswaController::class, 'importExcel'])->name('datamahasiswa.import');
    Route::get('/jadwal', [\App\Http\Controllers\JadwalController::class, 'index'])->name('jadwal');
    Route::post('/jadwal', [\App\Http\Controllers\JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/create', [\App\Http\Controllers\JadwalController::class, 'create'])->name('jadwal.create');
    Route::get('/jadwal/{id_kelas}/edit', [\App\Http\Controllers\JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{id_kelas}', [\App\Http\Controllers\JadwalController::class, 'update'])->name('jadwal.update');

    //ADMIN
    Route::get('/storage', [\App\Http\Controllers\StorageController::class, 'index'])->name('storage');
    //PROFILE
    Route::get('/profile/{id}', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile/{id}', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');




    // Authentication routes
    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
