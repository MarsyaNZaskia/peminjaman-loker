<?php

use App\Http\Controllers\Admin\BukuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Peminjam\PeminjamanController as PeminjamPeminjamanController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Petugas\LaporanController as PetugasLaporanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use App\Models\Buku;

// Google OAuth routes
Route::get('/auth/google', [SocialiteController::class, 'redirect'])
->name('google.redirect')
->withoutMiddleware(['guest', App\Http\Middleware\RedirectIfAuthenticated::class]);

Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])
->name('google.callback')
->withoutMiddleware(['guest', App\Http\Middleware\RedirectIfAuthenticated::class]);

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('users', UserController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('kategoris', KategoriController::class);

    // Routes Peminjaman 
    Route::resource('peminjaman', \App\Http\Controllers\Admin\PeminjamanController::class);
    
    // Routes Pengembalian 
    Route::get('/pengembalian', [\App\Http\Controllers\Admin\PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create/{peminjaman}', [\App\Http\Controllers\Admin\PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian/{peminjaman}', [\App\Http\Controllers\Admin\PengembalianController::class, 'store'])->name('pengembalian.store');
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
    Route::post('/laporan/buku', [AdminLaporanController::class, 'exportBuku'])->name('laporan.buku');

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
    Route::post('/laporan/buku', [PetugasLaporanController::class, 'exportBuku'])->name('laporan.buku');


});

// Peminjam routes
Route::middleware(['auth', 'peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/dashboard', function () {
        return view('peminjam.dashboard');
    })->name('dashboard');

    // Routes peminjaman - dengan middleware checkBiodata
    Route::middleware('checkBiodata')->group(function () {
        Route::get('/peminjaman', [PeminjamPeminjamanController::class, 'index'])->name('peminjaman.index');

        Route::get('/buku/{buku}', [PeminjamPeminjamanController::class, 'show'])->name('peminjaman.show');
        
        Route::get('/peminjaman/create/{buku}', [PeminjamPeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamPeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::delete('/peminjaman/{peminjaman}', [PeminjamPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    });

    // Routes riwayat peminjaman
    Route::get('/riwayat', [\App\Http\Controllers\Peminjam\RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{peminjaman}', [\App\Http\Controllers\Peminjam\RiwayatController::class, 'show'])->name('riwayat.show');

});


//Routes Grup (Semua Role)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/foto', [ProfileController::class, 'deleteFoto'])->name('profile.deleteFoto');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});



Route::post('/admin/users/import', [UserController::class, 'import'])->name('admin.users.import');
Route::post('/admin/buku/import', [BukuController::class, 'import'])->name('admin.buku.import');


Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        } else {
            return redirect()->route('peminjam.dashboard');
        }
    }

    return view('welcome'); // ← landing page kamu
})->name('landing');





// Route::get('/', function () {
//     return view('welcome');
// });
