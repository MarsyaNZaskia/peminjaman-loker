<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LokerController;
use App\Http\Controllers\Peminjam\PeminjamanController as PeminjamPeminjamanController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Petugas\LaporanController as PetugasLaporanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('users', UserController::class);
    Route::resource('lokers', LokerController::class);
    Route::resource('kategoris', KategoriController::class);

    // Routes Peminjaman 
    Route::resource('peminjaman', \App\Http\Controllers\Admin\PeminjamanController::class);
    
    // Routes Pengembalian 
    Route::get('/pengembalian', [\App\Http\Controllers\Admin\PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/{pengembalian}', [\App\Http\Controllers\Admin\PengembalianController::class, 'show'])->name('pengembalian.show');
    Route::get('/pengembalian/{pengembalian}/edit', [\App\Http\Controllers\Admin\PengembalianController::class, 'edit'])->name('pengembalian.edit');
    Route::put('/pengembalian/{pengembalian}', [\App\Http\Controllers\Admin\PengembalianController::class, 'update'])->name('pengembalian.update');
    Route::delete('/pengembalian/{pengembalian}', [\App\Http\Controllers\Admin\PengembalianController::class, 'destroy'])->name('pengembalian.destroy');

     // Routes Log Aktivitas
    Route::get('/log-aktivitas', [\App\Http\Controllers\Admin\LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    Route::get('/log-aktivitas/{logAktivita}', [\App\Http\Controllers\Admin\LogAktivitasController::class, 'show'])->name('log-aktivitas.show');
    Route::delete('/log-aktivitas/clear', [\App\Http\Controllers\Admin\LogAktivitasController::class, 'clear'])->name('log-aktivitas.clear');

    // Routes Laporan 
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/peminjaman', [AdminLaporanController::class, 'exportPeminjaman'])->name('laporan.peminjaman');
    Route::post('/laporan/pengembalian', [AdminLaporanController::class, 'exportPengembalian'])->name('laporan.pengembalian');
    Route::post('/laporan/loker', [AdminLaporanController::class, 'exportLoker'])->name('laporan.loker');

});

// Petugas routes
Route::middleware(['auth', 'petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');

    // Routes peminjaman
    Route::get('/peminjaman', [PetugasPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{peminjaman}', [PetugasPeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('/peminjaman/{peminjaman}/approve', [PetugasPeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{peminjaman}/reject', [PetugasPeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::get('/peminjaman/{peminjaman}/return', [PetugasPeminjamanController::class, 'return'])->name('peminjaman.return');

    // Routes pengembalian 
    Route::get('/pengembalian', [\App\Http\Controllers\Petugas\PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create/{peminjaman}', [\App\Http\Controllers\Petugas\PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian/{peminjaman}', [\App\Http\Controllers\Petugas\PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::get('/pengembalian/{pengembalian}/show', [\App\Http\Controllers\Petugas\PengembalianController::class, 'show'])->name('pengembalian.show');

    // Routes Laporan 
    Route::get('/laporan', [PetugasLaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/peminjaman', [PetugasLaporanController::class, 'exportPeminjaman'])->name('laporan.peminjaman');
    Route::post('/laporan/pengembalian', [PetugasLaporanController::class, 'exportPengembalian'])->name('laporan.pengembalian');
    Route::post('/laporan/loker', [PetugasLaporanController::class, 'exportLoker'])->name('laporan.loker');


});

// Peminjam routes
Route::middleware(['auth', 'peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/dashboard', function () {
        return view('peminjam.dashboard');
    })->name('dashboard');

    // Routes peminjaman
    Route::get('/peminjaman', [PeminjamPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create/{loker}', [PeminjamPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::delete('/peminjaman/{peminjaman}', [PeminjamPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

});

// routes/web.php
// Tambahkan di dalam grup admin middleware

Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/', function () {
//     return view('welcome');
// });
