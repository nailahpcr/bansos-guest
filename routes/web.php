<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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
Route::get('/', [DashboardController::class, 'indexPublic'])->name('home');

// Halaman Program Publik
Route::get('/program', [DashboardController::class, 'indexPublic'])->name('program.public.index');
Route::get('/program/{program}', [DashboardController::class, 'showPublic'])->name('program.public.show');    

Route::get('/about', [HomeController::class, 'about'])->name('about');

// Route Auth Umum
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'daftar']);
});
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');




// ========================================================
// 2. ROUTE TERLINDUNG (Membutuhkan Auth)
// ========================================================
Route::middleware(['auth'])->group(function () {

    // ========================================================
    // 3. ROUTE ADMIN (Membutuhkan Auth dan Role Admin)
    // ========================================================
    Route::group(['middleware' => ['checkrole:admin']], function () {
        Route::get('/admin', [ProgramController::class, 'indexAdmin'])->name('home-admin');
        
        Route::prefix('kelola-program')->name('kelola-program.')->group(function () {
            Route::get('/', [ProgramController::class, 'indexAdmin'])->name('index');
            Route::get('/create', [ProgramController::class, 'create'])->name('create');
            Route::post('/', [ProgramController::class, 'store'])->name('store');
            Route::get('/{program}', [ProgramController::class, 'show'])->name('show');
            Route::get('/{program}/edit', [ProgramController::class, 'edit'])->name('edit');
            Route::put('/{program}', [ProgramController::class, 'update'])->name('update');
            Route::delete('/{program}', [ProgramController::class, 'destroy'])->name('destroy');
            Route::post('/{program}/upload-media', [ProgramController::class, 'uploadMedia'])->name('uploadMedia');
            Route::delete('/media/{media_id}', [ProgramController::class, 'deleteMedia'])->name('deleteMedia');
            Route::post('/{program}/ajukan', [ProgramController::class, 'ajukanProgram'])->name('ajukan');
            Route::delete('/{program}/batalkan', [ProgramController::class, 'batalkanProgram'])->name('batalkan');
        });

        Route::resource('warga', WargaController::class);
        Route::resource('pendaftar', PendaftarController::class);

        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::delete('/pendaftar/files/{file}', [PendaftarController::class, 'destroyFile'])->name('pendaftar.files.destroy');
        Route::delete('/pendaftar/file/{id}', [PendaftarController::class, 'destroyFile'])->name('pendaftar.files.destroy');
        Route::delete('/verifikasi/file/{id}', [VerifikasiController::class, 'destroyFile'])->name('verifikasi.files.destroy');    
        Route::delete('kelola-program/{id}/delete-file', [ProgramController::class, 'deleteFile'])->name('kelola-program.delete-file');
    }); // <--- FIX: Kurung penutup grup admin

    // Route Resource Umum (Bisa diakses Admin & Warga asal Login)
    Route::resource('verifikasi', VerifikasiController::class);
    Route::resource('penerima', PenerimaBantuanController::class);
    Route::resource('riwayat', RiwayatPenyaluranController::class);

    // --- GRUP KHUSUS WARGA ---
    Route::group(['middleware' => ['checkrole:warga']], function () {
        Route::get('/home', [HomeController::class, 'indexWarga'])->name('home');

        Route::prefix('program-warga')->name('program-warga.')->group(function () {
            Route::get('/', [ProgramController::class, 'indexWarga'])->name('indexWarga');
            Route::post('/{program}/upload-media', [ProgramController::class, 'uploadMediaWarga'])->name('uploadMedia');
            Route::delete('/media/{media_id}', [ProgramController::class, 'deleteMediaWarga'])->name('deleteMedia');
            Route::post('/{program}/ajukan', [ProgramController::class, 'ajukanProgram'])->name('ajukan');
            Route::delete('/{program}/batalkan', [ProgramController::class, 'batalkanProgram'])->name('batalkan');
        });
    }); // <--- FIX: Kurung penutup grup warga harus di sini
    
}); // <--- FIX: Kurung penutup checkislogin
