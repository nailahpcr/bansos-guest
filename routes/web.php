<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramBantuanController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\Warga;

Route::get('dashboard', [DashboardController::class,'index']) ->name('dashboard'); 
Route::get('/program', [ProgramController::class, 'index']);

// Route untuk menampilkan halaman login
Route::get('/auth', [AuthController::class, 'index'])->name('login-form');

// Route untuk memproses data dari form login
Route::post('/auth/login', [AuthController::class, 'login'])->name('login-process');

// Route untuk halaman tujuan setelah login berhasil
// Route::get('/dashboard', function () {
//     // Memastikan hanya bisa diakses jika ada session 'success'
//     if (!session('success')) {
//         return redirect()->route('login-form');
//     }
//     return view('dashboard');
// })->name('dashboard');

Route::resource('program-bantuan', ProgramBantuanController::class);
Route::resource('/admin/program-bantuan', ProgramBantuanController::class);
Route::resource('warga', WargaController::class);
Route::get('/warga', [Warga::class, 'index']);
