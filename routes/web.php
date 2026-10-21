<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\penjualController;
use App\Http\Controllers\TambahUlasanController;
use App\Http\Controllers\TindakLanjutController;
use App\Models\penjual;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. Route Beranda / Dashboard Pembeli
Route::get('/', function () {
    $penjualList = penjual::all();
    return view('dashboard', compact('penjualList'));
})->name('dashboard');

// 2. Auth Routes Guest (Login & Register khusus Penjual)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// 3. Auth Routes (Khusus Penjual setelah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    // Halaman Utama / Dashboard Penjual
    Route::get('/homePenjual', function () {
        $penjual = penjual::find(Auth::id());
        return view('homePenjual', compact('penjual'));
    })->name('homePenjual');

    // Halaman Form Edit Data Penjual
    Route::get('/penjual/edit', function () {
        $penjual = penjual::find(Auth::id());
        return view('editPenjual', compact('penjual'));
    })->name('penjual.edit');

    // Halaman Lihat Ulasan khusus Penjual
    Route::get('/penjual/ulasan', function () {
        $penjual = penjual::find(Auth::id());
        return view('ViewUlasan', compact('penjual'));
    })->name('penjual.ulasan');

    // Proses Simpan / Update Data Penjual
    Route::post('simpan-penjual', [penjualController::class, 'store'])->name('penjual.store');

    // Hapus Ulasan (khusus penjual yang login)
    Route::delete('/ulasan/{id}', [penjualController::class, 'hapusUlasan'])->name('ulasan.destroy');

    // Tindak Lanjut Keluhan
    Route::get('/tindaklanjut', [TindakLanjutController::class, 'index'])->name('tindaklanjut.index');
    Route::get('/tindaklanjut/tambah', [TindakLanjutController::class, 'create'])->name('tindaklanjut.create');
    Route::post('/tindaklanjut', [TindakLanjutController::class, 'store'])->name('tindaklanjut.store');
    Route::get('/tindaklanjut/{id}/edit', [TindakLanjutController::class, 'edit'])->name('tindaklanjut.edit');
    Route::put('/tindaklanjut/{id}', [TindakLanjutController::class, 'update'])->name('tindaklanjut.update');
    Route::delete('/tindaklanjut/{id}', [TindakLanjutController::class, 'destroy'])->name('tindaklanjut.destroy');
});

// 4. Public Routes (Akses Umum Pembeli)
Route::get('/penjual/{id}', function ($id) {
    $penjual = penjual::findOrFail($id);
    return view('detail', compact('penjual'));
})->name('penjual.detail');

Route::get('/ulasan/{id}', function ($id) {
    $penjual = penjual::findOrFail($id);
    return view('formulasan', compact('penjual'));
})->name('ulasan.create');

use App\Http\Controllers\ResponController;

Route::post('/respon', [ResponController::class, 'store'])->name('respon.store');

Route::post('/ulasan', [TambahUlasanController::class, 'store'])->name('ulasan.store');