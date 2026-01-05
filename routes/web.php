<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\TransaksiStokController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('auth.login');
});

// Admin & Owner bisa akses route yang sama
Route::middleware(['auth', 'role:admin|owner'])->group(function () {
    Route::get('/admin-panel', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Bahan Baku
    Route::prefix('manajemen-bahan')->name('manajemen.bahan.')->group(function () {
        Route::get('/', [BahanController::class, 'index'])->name('index');
        Route::get('/create', [BahanController::class, 'create'])->name('create');
        Route::post('/', [BahanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BahanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BahanController::class, 'update'])->name('update');
        Route::delete('/{id}', [BahanController::class, 'destroy'])->name('destroy');
    });

    // Transaksi Stok
    Route::prefix('transaksi-stok')->name('transaksi.stok.')->group(function () {
        Route::get('/', [TransaksiStokController::class, 'index'])->name('index');
        Route::get('/create', [TransaksiStokController::class, 'create'])->name('create');
        Route::post('/', [TransaksiStokController::class, 'store'])->name('store');
    });

    // Manajemen User
    Route::prefix('manajemen-user')->name('manajemen.user.')->group(function () {
        Route::get('/', [ManajemenUserController::class, 'index'])->name('index');
        Route::get('/create', [ManajemenUserController::class, 'create'])->name('create');
        Route::post('/', [ManajemenUserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [ManajemenUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [ManajemenUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [ManajemenUserController::class, 'destroy'])->name('destroy');
    });
});

// Owner-only routes
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::resource('reports', ReportController::class)->except(['generate']);
    // Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin-panel', [DashboardController::class, 'index'])->name('admin.panel');
//     Route::get('/admin-manajemen-bahan', [BahanController::class, 'index'])->name('manajemen.bahan-admin');
//     Route::post('/admin-manajemen-bahan', [BahanController::class, 'store'])->name('manajemen.bahan-admin.store');
//     Route::get('/admin-manajemen-bahan/create', [BahanController::class, 'create'])->name('manajemen.bahan-admin.create');
//     Route::get('/admin-manajemen-bahan/{id}/edit', [BahanController::class, 'edit'])->name('manajemen.bahan-admin.edit');
//     Route::put('/admin-manajemen-bahan/{id}', [BahanController::class, 'update'])->name('manajemen.bahan-admin.update');
//     Route::delete('/admin-manajemen-bahan/{id}', [BahanController::class, 'destroy'])->name('manajemen.bahan-admin.destroy');

//     Route::get('/admin-transaksi-stok', [TransaksiStokController::class, 'index'])->name('transaksi.stok-admin');
//     Route::post('/admin-transaksi-stok', [TransaksiStokController::class, 'store'])->name('transaksi.stok-admin.store');
//     Route::get('/admin-transaksi-stok/create', [TransaksiStokController::class, 'create'])->name('transaksi.stok-admin.create');
//     // Manajemen User
//     Route::get('/admin-manajemen-user', [ManajemenUserController::class, 'index'])->name('manajemen.user-admin');
//     Route::get('/admin-manajemen-user/create', [ManajemenUserController::class, 'create'])->name('manajemen.user-admin.create');
//     Route::post('/admin-manajemen-user', [ManajemenUserController::class, 'store'])->name('manajemen.user-admin.store');
//     Route::delete('/admin-manajemen-user/{id}', [ManajemenUserController::class, 'destroy'])->name('manajemen.user-admin.destroy');
// });

// Route::middleware(['auth', 'role:owner'])->group(function () {
//     Route::get('/owner-panel', [DashboardController::class, 'index'])->name('owner.panel');

//     Route::get('/owner-manajemen-bahan', [BahanController::class, 'index'])->name('manajemen.bahan-owner');
//     Route::post('/owner-manajemen-bahan', [BahanController::class, 'store'])->name('manajemen.bahan-owner.store');
//     Route::get('/owner-manajemen-bahan/create', [BahanController::class, 'create'])->name('manajemen.bahan-owner.create');
//     Route::get('/owner-manajemen-bahan/{id}/edit', [BahanController::class, 'edit'])->name('manajemen.bahan-owner.edit');
//     Route::put('/owner-manajemen-bahan/{id}', [BahanController::class, 'update'])->name('manajemen.bahan-owner.update');
//     Route::delete('/owner-manajemen-bahan/{id}', [BahanController::class, 'destroy'])->name('manajemen.bahan-owner.destroy');

//     Route::get('/owner-transaksi-stok', [TransaksiStokController::class, 'index'])->name('transaksi.stok-owner');
//       // Baru buat yg User
//     Route::get('/owner-manajemen-user', [ManajemenUserController::class, 'index'])->name('manajemen.user-owner');
//     Route::get('/owner-manajemen-user/create', [ManajemenUserController::class, 'create'])->name('manajemen.user-owner.create');
//     Route::post('/owner-manajemen-user', [ManajemenUserController::class, 'store'])->name('manajemen.user-owner.store');
//     Route::delete('/owner-manajemen-user/{id}', [ManajemenUserController::class, 'destroy'])->name('manajemen.user-owner.destroy');
//     Route::get('/owner-laporan', [LaporanController::class, 'index'])->name('laporan-owner');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
