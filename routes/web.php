<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\PrometheusExporter;
// Route::get('/metrics', function () {
//     $prometheus = app(\Prometheus\CollectorRegistry::class);
//     $renderer = new \Prometheus\RenderTextFormat();
//     $metrics = $renderer->render($prometheus->getMetricFamilySamples());

//     return response($metrics)->header('Content-Type', \Prometheus\RenderTextFormat::MIME_TYPE);
// });
Route::get('/metrics', [PrometheusExporter::class, 'exportMetrics']);

Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::get('/', [\App\Http\Controllers\LoginController::class, 'index']);
// Logout harus method POST
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// Public routes (accessible without authentication)
Route::middleware('guest')->group(function() {
    Route::get('/sesi', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('/sesi/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
    Route::get('/branding', function () {
        return view('layouts.branding'); // Perhatikan path 'layout.profiles'
    });
    
});

// Protected routes (require authentication)
Route::middleware(['auth', 'isLogin'])->group(function() {
    // Application routes
    Route::get('/sesi/signup', [\App\Http\Controllers\LoginController::class, 'create'])->name('register');
    Route::post('/sesi', [\App\Http\Controllers\LoginController::class, 'store'])->name('register');

    //TAMU
    Route::get('/tamu', [\App\Http\Controllers\TamusController::class, 'index'])->name('tamu');
    Route::post('/tamu', [\App\Http\Controllers\TamusController::class, 'store'])->name('tamu');
    Route::get('/tamu/create', [\App\Http\Controllers\TamusController::class, 'create'])->name('tamu');

    Route::get('/tamu/path', [\App\Http\Controllers\PathController::class, 'indexPath'])->name('path');
    Route::get('/tamu/path/create', [\App\Http\Controllers\PathController::class, 'createPath'])->name('path');
    Route::post('/tamu/path', [\App\Http\Controllers\PathController::class, 'storePath'])->name('path');
    Route::delete('/tamu/path/{id}', [\App\Http\Controllers\PathController::class, 'destroy'])->name('path');


    //MAHASISWA
    Route::get('/mahasiswa', [\App\Http\Controllers\MahasiswasController::class, 'index'])->name('mahasiswa');
    Route::get('/mahasiswa/create', [\App\Http\Controllers\MahasiswasController::class, 'create'])->name('mahasiswa');
    Route::get('/datamahasiswa', [\App\Http\Controllers\DatamahasiswaController::class, 'index'])->name('datamahasiswa');
    Route::get('/datamahasiswa/create', [\App\Http\Controllers\DatamahasiswaController::class, 'create'])->name('datamahasiswa');
    Route::post('/datamahasiswa', [\App\Http\Controllers\DatamahasiswaController::class, 'store'])->name('datamahasiswa');
    Route::delete('/datamahasiswa/{id_mahasiswa}', [\App\Http\Controllers\DatamahasiswaController::class, 'destroy'])->name('datamahasiswa');
    Route::get('/jadwal', [\App\Http\Controllers\JadwalController::class, 'index'])->name('jadwal');
    Route::post('/jadwal', [\App\Http\Controllers\JadwalController::class, 'store'])->name('jadwal');
    Route::get('/jadwal/create', [\App\Http\Controllers\JadwalController::class, 'create'])->name('jadwal');
    Route::delete('/jadwal/{id_kelas}', [\App\Http\Controllers\JadwalController::class, 'destroy'])->name('jadwal');
    //ADMIN
    Route::get('/storage', [\App\Http\Controllers\StorageController::class, 'index'])->name('storage');
    //PROFILE
    Route::get('/profile/{id}', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile/{id}', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    


    
    // Authentication routes
    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
