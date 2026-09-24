<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengajuanBeritaController;

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

//AUTENTIKASI
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//USER
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [PengajuanBeritaController::class, 'userDashboard'])->name('dashboard');
    Route::get('/pengajuan', [PengajuanBeritaController::class, 'create'])->name('pengajuan');
    Route::post('/pengajuan', [PengajuanBeritaController::class, 'store'])->name('pengajuan.store');
    Route::get('/monitoring', [PengajuanBeritaController::class, 'monitoring'])->name('monitoring');
});

//ADMIN
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [PengajuanBeritaController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/kelola-pengajuan', [PengajuanBeritaController::class, 'index'])->name('pengajuan.index');
    Route::get('/detail-pengajuan/{id}', [PengajuanBeritaController::class, 'show'])->name('pengajuan.show');
    Route::patch('/update-status/{id}', [PengajuanBeritaController::class, 'updateStatus'])->name('pengajuan.updateStatus');
    Route::get('/rekapitulasi', [PengajuanBeritaController::class, 'rekapitulasi'])->name('rekapitulasi');
});