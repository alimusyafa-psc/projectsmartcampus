<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/sesi',[\App\Http\Controllers\LoginController::class,'index']);
Route::post('/sesi/login',[\App\Http\Controllers\LoginController::class,'login']);
Route::get('/tamu',[\App\Http\Controllers\TamusController::class,'index']);
Route::post('/tamu',[\App\Http\Controllers\TamusController::class,'store']);
Route::get('/tamu/create',[\App\Http\Controllers\TamusController::class,'create']);
Route::get('/datamahasiswa',[\App\Http\Controllers\DatamahasiswaController::class,'index']);
Route::get('/datamahasiswa/create',[\App\Http\Controllers\DatamahasiswaController::class,'create']);
Route::delete('/datamahasiswa/{id_mahasiswa}',[\App\Http\Controllers\DatamahasiswaController::class,'destroy']);
Route::post('/datamahasiswa',[\App\Http\Controllers\DatamahasiswaController::class,'store']);
Route::get('/jadwal',[\App\Http\Controllers\JadwalController::class,'index']);
Route::post('/jadwal',[\App\Http\Controllers\JadwalController::class,'store']);
Route::get('/jadwal/create',[\App\Http\Controllers\JadwalController::class,'create']);
Route::delete('/jadwal/{id_kelas}',[\App\Http\Controllers\JadwalController::class,'destroy']);
Route::get('/mahasiswa',[\App\Http\Controllers\MahasiswasController::class,'index']);
Route::get('/mahasiswa/create',[\App\Http\Controllers\MahasiswasController::class,'create']);
Route::get('/storage',[\App\Http\Controllers\StorageController::class,'index']);
Route::post('/sesi',[\App\Http\Controllers\LoginController::class,'store']);
Route::get('/sesi/signup',[\App\Http\Controllers\LoginController::class,'create']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

