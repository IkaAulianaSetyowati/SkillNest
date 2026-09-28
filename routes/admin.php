<?php

use App\Http\Controllers\Admin\CrudController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use Illuminate\Support\Facades\Route;

// ==========================================================================
// AUTH ADMIN (login/logout — tidak butuh sudah login)
// ==========================================================================

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// ==========================================================================
// HALAMAN ADMIN (butuh sudah login)
// ==========================================================================

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    // CRUD Webinar, Kategori, Pengguna, Organizer, Transaksi (diatur di config/crud.php)
    foreach (array_keys(config('crud')) as $k) {
        Route::resource($k, CrudController::class)->only(['index', 'store', 'update', 'destroy']);
    }

    // Halaman yang belum dibuat
    foreach (['laporan' => 'Laporan', 'pengaturan' => 'Pengaturan Sistem', 'log' => 'Log Aktivitas'] as $u => $t) {
        Route::view($u, 'admin.soon', ['title' => $t])->name($u);
    }
});