<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webinar;
use App\Models\WebinarRegistration;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $organizerId = auth()->id();

        // 1. Hitung total webinar milik organizer yang sedang login
        $totalWebinar = Webinar::where('user_id', $organizerId)->count();

        // Ambil daftar ID webinar milik organizer ini untuk relasi pendaftaran/transaksi
        $webinarIds = Webinar::where('user_id', $organizerId)->pluck('id');

        // 2. Hitung total pendaftar dari semua webinar milik organizer ini
        $totalPendaftar = WebinarRegistration::whereIn('webinar_id', $webinarIds)->count();

        // 3. Hitung total pendapatan (sesuaikan nama kolom tabel transaksi/harga jika berbeda)
        $totalPendapatan = WebinarRegistration::whereIn('webinar_id', $webinarIds)
            ->sum('total_price'); // Ganti 'total_price' dengan kolom harga/pendapatan di tabel Anda jika berbeda

        // 4. Rata-rata rating (jika ada kolom rating di tabel webinar atau ulasan)
        $rataRating = Webinar::where('user_id', $organizerId)->avg('rating') ?? 4.8; 

        return view('organizer.dashboard', compact(
            'totalWebinar', 
            'totalPendaftar', 
            'totalPendapatan', 
            'rataRating'
        ));
    }
}