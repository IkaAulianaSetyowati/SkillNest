<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\{Organizer, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, RateLimiter, Storage};
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin() { return view('organizer.auth.login'); }
    public function showRegister() { return view('organizer.auth.register'); }

    public function login(Request $r)
    {
        $d = $r->validate(['email' => 'required|email', 'password' => 'required']);
        $key = 'organizer-login|' . Str::lower($d['email']) . '|' . $r->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages(['email' => 'Terlalu banyak percobaan. Coba lagi dalam ' . RateLimiter::availableIn($key) . ' detik.']);
        }

        // Hanya peran Organizer + status Aktif yang lolos; pesan error sengaja seragam.
        if (! Auth::attempt($d + ['peran' => 'Organizer', 'status' => 'Aktif'])) {
            RateLimiter::hit($key, 300);
            throw ValidationException::withMessages(['email' => 'Email atau password salah.']);
        }

        RateLimiter::clear($key);
        $r->session()->regenerate();

        // Middleware yang memutuskan: terverifikasi -> dashboard, belum -> halaman menunggu.
        return redirect()->route('organizer.dashboard');
    }

    public function register(Request $r)
    {
        $d = $r->validate([
            'nama' => 'required|string|max:100|unique:organizers,nama',
            'name' => 'required|string|max:100',
            'email' => 'required|email:rfc|max:150|unique:users,email',
            'telepon' => ['required', 'regex:/^(\+62|62|0)8[0-9]{8,12}$/'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'setuju' => 'accepted',
        ]);

        DB::transaction(function () use ($d, $r) {
            $u = User::forceCreate([
                'name' => $d['name'], 'email' => $d['email'], 'password' => Hash::make($d['password']),
                'peran' => 'Organizer', 'status' => 'Aktif',
            ]);
            Organizer::forceCreate([
                'user_id' => $u->id, 'nama' => $d['nama'], 'kontak' => $d['email'], 'telepon' => $d['telepon'],
                'verifikasi' => 'Menunggu', 'dokumen_path' => $r->file('dokumen')->store('dokumen-organizer'),
            ]);
        });

        return redirect()->route('organizer.login')
            ->with('ok', 'Pendaftaran diterima. Dashboard baru terbuka setelah admin memverifikasi akun Anda.');
    }

    public function menunggu(Request $r)
    {
        $o = Organizer::where('user_id', $r->user()->id)->firstOrFail();

        if ($o->verifikasi === 'Terverifikasi') return redirect()->route('organizer.dashboard');

        return view('organizer.menunggu', ['o' => $o]);
    }

    public function ajukanUlang(Request $r)
    {
        $o = Organizer::where('user_id', $r->user()->id)->firstOrFail();
        abort_unless($o->verifikasi === 'Ditolak', 403);

        $r->validate(['dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048']);
        if ($o->dokumen_path) Storage::delete($o->dokumen_path);

        $o->forceFill([
            'dokumen_path' => $r->file('dokumen')->store('dokumen-organizer'),
            'verifikasi' => 'Menunggu', 'alasan_penolakan' => null,
        ])->save();

        return back()->with('ok', 'Dokumen dikirim ulang. Mohon tunggu peninjauan admin.');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect()->route('organizer.login');
    }
}