<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengajuanBeritaController;
use App\Http\Controllers\UserManagementController;

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// AUTENTIKASI
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// REGISTER
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
    
    // KELOLA PENGAJUAN & TAMBAH BERITA LANGSUNG
    Route::get('/kelola-pengajuan', [PengajuanBeritaController::class, 'index'])->name('pengajuan.index');
    Route::get('/kelola-pengajuan/create', [PengajuanBeritaController::class, 'adminCreate'])->name('pengajuan.create');
    Route::post('/kelola-pengajuan/store', [PengajuanBeritaController::class, 'adminStore'])->name('pengajuan.store');
    
    // DETAIL & UPDATE STATUS PENGAJUAN
    Route::get('/detail-pengajuan/{id}', [PengajuanBeritaController::class, 'show'])->name('pengajuan.show');
    Route::put('/update-status/{id}', [PengajuanBeritaController::class, 'updateStatus'])->name('pengajuan.updateStatus');
    
    // REKAPITULASI LAPORAN & EKSPOR EXCEL
    Route::get('/rekapitulasi', [PengajuanBeritaController::class, 'rekapitulasi'])->name('rekapitulasi');

    // USER MANAGEMENT (Lengkap: Read, Create, Update, Delete)
    Route::get('/users', [UserManagementController::class, 'indexUsers'])->name('users.index');
    Route::post('/users', [UserManagementController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [UserManagementController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [UserManagementController::class, 'destroyUser'])->name('users.destroy');
    
    Route::get('/kategori', [UserManagementController::class, 'indexKategori'])->name('kategori.index');
    Route::post('/kategori', [UserManagementController::class, 'storeKategori'])->name('kategori.store');
    Route::put('/kategori/{id}', [UserManagementController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{id}', [UserManagementController::class, 'destroyKategori'])->name('kategori.destroy');

    Route::get('/prodi-unit', [UserManagementController::class, 'indexProdi'])->name('prodi.index');
    Route::post('/prodi-unit', [UserManagementController::class, 'storeProdi'])->name('prodi.store');
    Route::put('/prodi-unit/{id}', [UserManagementController::class, 'updateProdi'])->name('prodi.update');
    Route::delete('/prodi-unit/{id}', [UserManagementController::class, 'destroyProdi'])->name('prodi.destroy');
});