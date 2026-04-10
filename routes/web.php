<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeramalanController;
use App\Http\Controllers\LaporanController;

// 1. Guest Routes (Halaman sebelum login)
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Auth Routes (Harus login dulu)
Route::middleware(['auth'])->group(function () {
    
    // Semua Role bisa akses Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // --- KHUSUS ADMIN & GUDANG ---
    Route::middleware(['can:access-barang'])->group(function () {
        Route::resource('barang', BarangController::class);
    });
    
    // --- KHUSUS ADMIN & MANAJER ---
    Route::middleware(['can:access-peramalan'])->group(function () {
        Route::get('/peramalan', [PeramalanController::class, 'index'])->name('peramalan.index');
        Route::post('/peramalan/hitung', [PeramalanController::class, 'hitung'])->name('peramalan.hitung');
    });

    // --- KHUSUS ADMIN, MANAJER & KASIR ---
    Route::middleware(['can:access-laporan'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');
        // --- TAMBAHKAN DUA BARIS INI UNTUK CRUD ---
        Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
        Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
        Route::delete('/laporan-bulk-delete', [LaporanController::class, 'bulkDelete'])->name('laporan.bulkDelete');
    });
});