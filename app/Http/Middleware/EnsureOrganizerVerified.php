<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizerVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login dan memiliki role organizer
        if (auth()->check() && auth()->user()->role === 'organizer') {
            
            // Ambil data relasi organizer (sesuaikan dengan struktur database kamu)
            $organizer = auth()->user()->organizer;

            // Periksa apakah organizer sudah disetujui/diverifikasi
            if ($organizer && $organizer->verifikasi === 'Disetujui') {
                return $next($request);
            }

            // Jika belum diverifikasi, arahkan ke halaman tunggu atau beri pesan error
            return redirect()->route('organizer.pending')
                ->with('err', 'Akun organizer Anda masih menunggu verifikasi dari Administrator.');
        }

        // Jika bukan organizer atau belum login
        abort(403, 'Anda tidak memiliki akses ke halaman organizer.');
    }
}