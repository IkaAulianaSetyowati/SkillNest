<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $peran
     */
    public function handle(Request $request, Closure $next, string $peran): Response
    {
        $user = $request->user();

        // 1. Cek apakah user sudah login atau belum
        if (!$user) {
            return redirect('/login');
        }

        // 2. Cek status akun (Pastikan kolom 'status' ada di tabel users)
        if (isset($user->status) && $user->status !== 'Aktif') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect($peran === 'Organizer' ? route('organizer.login') : '/login')
                ->withErrors(['email' => 'Akun Anda dinonaktifkan.']);
        }

        // 3. Cek peran atau role (Mendukung kolom 'peran' atau 'role' di database)
        $userRole = $user->peran ?? $user->role ?? '';

        if ($userRole !== $peran) {
            abort(403, 'Anda tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}