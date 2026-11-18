<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengajuanBeritaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\ProdiUnitController;

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// AUTENTIKASI
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.proses');

// USER
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [PengajuanBeritaController::class, 'userDashboard'])->name('dashboard');
    Route::get('/pengajuan', [PengajuanBeritaController::class, 'create'])->name('pengajuan');
    Route::post('/pengajuan', [PengajuanBeritaController::class, 'store'])->name('pengajuan.store');
    Route::get('/monitoring', [PengajuanBeritaController::class, 'monitoring'])->name('monitoring');
});

// ADMIN
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [PengajuanBeritaController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/kelola-pengajuan', [PengajuanBeritaController::class, 'index'])->name('pengajuan.index');
    Route::get('/detail-pengajuan/{id}', [PengajuanBeritaController::class, 'show'])->name('pengajuan.show');
    Route::patch('/update-status/{id}', [PengajuanBeritaController::class, 'updateStatus'])->name('pengajuan.updateStatus');
    Route::get('/rekapitulasi', [PengajuanBeritaController::class, 'rekapitulasi'])->name('rekapitulasi');

    // Manajemen (Users, Kategori, Prodi)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/kategori', [KategoriBeritaController::class, 'adminIndex'])->name('kategori.index');
    Route::post('/kategori', [KategoriBeritaController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [KategoriBeritaController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriBeritaController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/prodi', [ProdiUnitController::class, 'adminIndex'])->name('prodi.index');
    Route::post('/prodi', [ProdiUnitController::class, 'store'])->name('prodi.store');
    Route::put('/prodi/{id}', [ProdiUnitController::class, 'update'])->name('prodi.update');
    Route::delete('/prodi/{id}', [ProdiUnitController::class, 'destroy'])->name('prodi.destroy');
});
