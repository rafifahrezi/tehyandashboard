<?php

use App\Http\Controllers\BahanController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\TransaksiStokController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/analytics', [DashboardController::class, 'analytics'])
    ->name('analytics');

Route::get('/profile', [DashboardController::class, 'profile'])
    ->name('profile');

Route::get('/manajemen-bahan', [BahanController::class, 'index'])->name('manajemen.bahan');
Route::post('/manajemen-bahan', [BahanController::class, 'store'])->name('manajemen.bahan.store');


Route::get('/transaksi-stok', [TransaksiStokController::class, 'index'])->name('transaksi.stok');
Route::get('/manajemen-user', [ManajemenUserController::class, 'index'])->name('manajemen.user');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');