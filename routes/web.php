<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PendaftarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\PenerimaBantuanController;
use App\Http\Controllers\RiwayatPenyaluranController;

// ========================================================
// 1. ROUTE PUBLIK (Tidak perlu Auth)
// ========================================================

// Route Halaman Depan
Route::get('/', [ProgramController::class, 'indexPublic'])->name('home');

// Halaman Program Publik
Route::get('/program', [ProgramController::class, 'indexPublic'])->name('program.public.index');
Route::get('/program/{program}', [ProgramController::class, 'showPublic'])->name('program.show'); // Ubah ke showPublic

Route::get('/about', [HomeController::class, 'about'])->name('about');

// Route Auth Umum
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'daftar']);
});
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

// ========================================================
// 2. ROUTE TERLINDUNG (Membutuhkan Auth)
// ========================================================

Route::middleware(['auth'])->group(function () {
    
    // Grup Route untuk Pengelolaan Program (Admin/Staff)
    Route::prefix('kelola-program')->name('kelola-program.')->group(function () {
        
        // CRUD Program Manual
        Route::get('/', [ProgramController::class, 'index'])->name('index');
        Route::get('/create', [ProgramController::class, 'create'])->name('create');
        Route::post('/', [ProgramController::class, 'store'])->name('store');
        Route::get('/{program}', [ProgramController::class, 'show'])->name('show');
        Route::get('/{program}/edit', [ProgramController::class, 'edit'])->name('edit');
        Route::put('/{program}', [ProgramController::class, 'update'])->name('update');
        Route::delete('/{program}', [ProgramController::class, 'destroy'])->name('destroy');
        
        // Route untuk Unggahan Media/Dokumen
        Route::post('/{program}/upload-media', [ProgramController::class, 'uploadMedia'])->name('uploadMedia');
        
        // Route untuk Delete Media
        Route::delete('/media/{media_id}', [ProgramController::class, 'deleteMedia'])->name('deleteMedia');
        
        // Route untuk Aksi Partisipasi Program
        Route::post('/{program}/ajukan', [ProgramController::class, 'ajukanProgram'])->name('ajukan');
        Route::delete('/{program}/batalkan', [ProgramController::class, 'batalkanProgram'])->name('batalkan');
    });

    // Route Resource lainnya
    Route::resource('warga', WargaController::class);
    Route::resource('user', UserController::class)->parameters(['user' => 'users']);
    Route::resource('pendaftar', PendaftarController::class);

    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::delete('/pendaftar/files/{file}', [PendaftarController::class, 'destroyFile'])->name('pendaftar.files.destroy');

//     Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);
});

Route::resource('verifikasi', VerifikasiController::class);
Route::resource('penerima', PenerimaBantuanController::class);
Route::resource('riwayat', RiwayatPenyaluranController::class);