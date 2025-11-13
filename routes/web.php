<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'daftar']);
});

Route::get('/program', [ProgramController::class, 'indexPublic'])->name('program.public.index');
// Route::get('/program/{program}', [ProgramController::class, 'showPublic'])->name('program.public.show');

Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('warga.dashboard');

// Route::prefix('kelola-program')->name('program.')->group(function () {
//     Route::get('/', [ProgramController::class, 'index'])->name('index');
//     Route::get('/create', [ProgramController::class, 'create'])->name('create');
//     Route::post('/', [ProgramController::class, 'store'])->name('store');
//     Route::get('/{program}', [ProgramController::class, 'show'])->name('show');
//     Route::get('/{program}/edit', [ProgramController::class, 'edit'])->name('edit');
//     Route::put('/{program}', [ProgramController::class, 'update'])->name('update');
//     Route::delete('/{program}', [ProgramController::class, 'destroy'])->name('destroy');
// });

Route::resource('kelola-program', ProgramController::class)->parameters([
    'kelola-program' => 'program',]);


Route::post('/program/{program}/ajukan', [ProgramController::class, 'ajukanProgram'])->name('program.ajukan');
Route::delete('/program/{program}/batalkan', [ProgramController::class, 'batalkanProgram'])->name('program.batalkan');
Route::resource('warga', WargaController::class);
Route::resource('user', UserController::class);
