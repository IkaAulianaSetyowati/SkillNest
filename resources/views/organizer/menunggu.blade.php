@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-16 bg-white p-8 rounded-2xl shadow-sm border border-gray-200 text-center space-y-6">
    <!-- Icon Jam / Pending -->
    <div class="w-16 h-16 mx-auto bg-amber-50 text-amber-600 rounded-full flex items-center justify-center text-2xl">
        <i class="fas fa-hourglass-half"></i>
    </div>

    <div class="space-y-2">
        <h2 class="text-2xl font-bold text-gray-900">Akun Menunggu Verifikasi</h2>
        <p class="text-xs text-gray-500 leading-relaxed">
            Terima kasih telah mendaftar sebagai organizer di SkillNest. Akun kamu saat ini sedang ditinjau oleh Admin agar dapat dipastikan keamanannya.
        </p>
    </div>

    <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 text-xs text-amber-800 text-left space-y-1">
        <p class="font-bold">Informasi:</p>
        <p>Proses verifikasi biasanya memakan waktu 1x24 jam. Kamu akan mendapatkan notifikasi atau dapat mencoba login kembali secara berkala.</p>
    </div>

    <div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-3 bg-gray-100 text-gray-700 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-gray-200 transition-colors">
                Keluar / Logout
            </button>
        </form>
    </div>
</div>
@endsection