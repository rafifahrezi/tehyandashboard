<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\TransaksiStokController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-panel', [DashboardController::class, 'index'])->name('admin.panel');

    Route::get('/admin-manajemen-bahan', [BahanController::class, 'index'])->name('manajemen.bahan-admin');
    Route::post('/admin-manajemen-bahan', [BahanController::class, 'store'])->name('manajemen.bahan-admin.store');
    Route::get('/admin-manajemen-bahan/create', [BahanController::class, 'create'])->name('manajemen.bahan-admin.create');
    Route::get('/admin-manajemen-bahan/{id}/edit', [BahanController::class, 'edit'])->name('manajemen.bahan-admin.edit');
    Route::put('/admin-manajemen-bahan/{id}', [BahanController::class, 'update'])->name('manajemen.bahan-admin.update');
    Route::delete('/admin-manajemen-bahan/{id}', [BahanController::class, 'destroy'])->name('manajemen.bahan-admin.destroy');

    Route::get('/admin-transaksi-stok', [TransaksiStokController::class, 'index'])->name('transaksi.stok-admin');
    Route::get('/admin-manajemen-user', [ManajemenUserController::class, 'index'])->name('manajemen.user-admin');
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner-panel', [DashboardController::class, 'index'])->name('owner.panel');

    Route::get('/owner-manajemen-bahan', [BahanController::class, 'index'])->name('manajemen.bahan-owner');
    Route::post('/owner-manajemen-bahan', [BahanController::class, 'store'])->name('manajemen.bahan-owner.store');
    Route::get('/owner-manajemen-bahan/create', [BahanController::class, 'create'])->name('manajemen.bahan-owner.create');
    Route::get('/owner-manajemen-bahan/{id}/edit', [BahanController::class, 'edit'])->name('manajemen.bahan-owner.edit');
    Route::put('/owner-manajemen-bahan/{id}', [BahanController::class, 'update'])->name('manajemen.bahan-owner.update');
    Route::delete('/owner-manajemen-bahan/{id}', [BahanController::class, 'destroy'])->name('manajemen.bahan-owner.destroy');

    Route::get('/owner-transaksi-stok', [TransaksiStokController::class, 'index'])->name('transaksi.stok-owner');
    Route::get('/owner-manajemen-user', [ManajemenUserController::class, 'index'])->name('manajemen.user-owner');

    Route::get('/owner-laporan', [LaporanController::class, 'index'])->name('laporan-owner');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
