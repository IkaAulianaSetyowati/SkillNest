<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Organizer\PageController;
use App\Http\Controllers\WebinarRegistrationController;
use App\Http\Controllers\OrganizerDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - SkillNest
|--------------------------------------------------------------------------
*/

// ==========================================================================
// SWITCH BAHASA
// ==========================================================================

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');


// ==========================================================================
// HALAMAN PUBLIK
// ==========================================================================

Route::get('/', [HomeController::class, 'index'])
    ->name('home');


// ==========================================================================
// WEBINAR PUBLIK
// ==========================================================================

Route::get('/webinars', [WebinarController::class, 'index'])
    ->name('webinars.index');

Route::get('/webinars/{id}', [WebinarController::class, 'show'])
    ->name('webinars.show');


// ==========================================================================
// KATEGORI PUBLIK
// ==========================================================================

Route::get('/kategori', [KategoriController::class, 'index'])
    ->name('categories');

Route::get('/kategori/{slug}', [KategoriController::class, 'show'])
    ->name('categories.show');


// ==========================================================================
// HALAMAN ORGANIZER PUBLIK (landing page ajakan bergabung)
// ==========================================================================

Route::get('/organizer', [PageController::class, 'index'])
    ->name('organizer.landing');

// Halaman menunggu verifikasi organizer (hanya bisa diakses jika sudah login)
Route::get('/organizer/menunggu', function () {
    return view('organizer.menunggu');
})->name('organizer.menunggu')->middleware(['auth']);


// ==========================================================================
// HALAMAN KHUSUS PENGGUNA LOGIN (peserta biasa)
// ==========================================================================

Route::middleware('auth')->group(function () {

    // ----------------------------------------------------------------------
    // DASHBOARD USER
    // ----------------------------------------------------------------------
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ----------------------------------------------------------------------
    // PROFIL USER
    // ----------------------------------------------------------------------
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // ----------------------------------------------------------------------
    // RIWAYAT
    // ----------------------------------------------------------------------
    Route::get('/riwayat', function (Request $request) {
        $registrations = \App\Models\WebinarRegistration::with('webinar')
                            ->where('user_id', $request->user()->id)
                            ->where('status', 'approved')
                            ->latest()
                            ->get();

        return view('user.history', compact('registrations'));
    })->name('history.index');

    // ----------------------------------------------------------------------
    // TIKET
    // ----------------------------------------------------------------------
    Route::get('/tiket', [WebinarRegistrationController::class, 'myTickets'])
        ->name('tickets.index');

    // ----------------------------------------------------------------------
    // WISHLIST
    // ----------------------------------------------------------------------
    Route::get('/wishlist', function () {
        return view('user.wishlist');
    })->name('wishlist.index');

    // ----------------------------------------------------------------------
    // JADWAL
    // ----------------------------------------------------------------------
    Route::get('/jadwal', function (Request $request) {
        $registrations = \App\Models\WebinarRegistration::with('webinar')
                            ->where('user_id', $request->user()->id)
                            ->where('status', 'approved')
                            ->latest()
                            ->get();

        return view('user.schedule', compact('registrations'));
    })->name('schedule.index');

    // ----------------------------------------------------------------------
    // PENDAFTARAN & PEMBAYARAN WEBINAR BERTAHAP
    // ----------------------------------------------------------------------
    Route::post('/webinars/{webinar}/register', [WebinarRegistrationController::class, 'store'])
        ->name('webinars.register');

    Route::get('/pendaftaran/{registration}/metode-bayar', [WebinarRegistrationController::class, 'showPaymentMethod'])
        ->name('webinars.payment.method');
        
    Route::post('/pendaftaran/{registration}/metode-bayar', [WebinarRegistrationController::class, 'storePaymentMethod'])
        ->name('webinars.payment.method.store');

    Route::get('/pendaftaran/{registration}/upload-bukti', [WebinarRegistrationController::class, 'showUploadForm'])
        ->name('webinars.upload.form');
        
    Route::post('/pendaftaran/{registration}/upload-bukti', [WebinarRegistrationController::class, 'submitUpload'])
        ->name('webinars.upload.submit');

    Route::get('/pendaftaran/{registration}/menunggu', [WebinarRegistrationController::class, 'waiting'])
        ->name('webinars.waiting');
        
    Route::get('/pendaftaran/{registration}/e-ticket', [WebinarRegistrationController::class, 'eTicket'])
        ->name('webinars.e-ticket');

    // ----------------------------------------------------------------------
    // LOGOUT USER
    // ----------------------------------------------------------------------
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

});


// ==========================================================================
// AUTHENTICATION BAWAAN LARAVEL (Breeze: /login, /register, dst)
// ==========================================================================

require __DIR__ . '/auth.php';


// ==========================================================================
// DASHBOARD ADMIN & ORGANIZER TAMBAHAN
// ==========================================================================

require __DIR__ . '/admin.php';
require __DIR__ . '/organizer.php';