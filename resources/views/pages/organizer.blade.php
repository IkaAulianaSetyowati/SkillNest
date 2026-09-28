@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- HERO BANNER UNGU -->
    <div class="relative bg-indigo-600 rounded-3xl p-8 md:p-12 text-center text-white overflow-hidden shadow-lg">
        <div class="relative z-10 max-w-3xl mx-auto space-y-4">
            <span class="px-3 py-1 bg-indigo-500/50 rounded-full text-xs font-medium tracking-wide uppercase">
                Fitur Organizer & Partner
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight">
                Gelar Webinar Kamu & Jangkau Ribuan Peserta
            </h1>
            <p class="text-sm md:text-base text-indigo-100">
                Platform terbaik untuk mengadakan event online, pelatihan, dan workshop dengan mudah, cepat, dan terorganisir.
            </p>
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                @auth
                    @if (auth()->user()->peran === 'Organizer')
                        <a href="{{ route('organizer.dashboard') }}" class="inline-block px-6 py-3 bg-white text-indigo-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-gray-50 transition-colors shadow-md">
                            Buka Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('organizer.register') }}" class="inline-block px-6 py-3 bg-white text-indigo-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-gray-50 transition-colors shadow-md">
                            Daftar Akun Organizer
                        </a>
                    @endif
                @else
                    <a href="{{ route('organizer.register') }}" class="inline-block px-6 py-3 bg-white text-indigo-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-gray-50 transition-colors shadow-md">
                        Daftar Akun Organizer
                    </a>
                    <a href="{{ route('organizer.login') }}" class="inline-block px-6 py-3 border border-white/60 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-white/10 transition-colors">
                        Masuk sebagai Organizer
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- KARTU FITUR (3 KOLOM) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Kartu 1 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm text-center space-y-3">
            <div class="w-12 h-12 mx-auto bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-lg"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm">Manajemen Peserta</h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                Pantau pendaftaran peserta secara real-time melalui dashboard admin yang intuitif.
            </p>
        </div>

        <!-- Kartu 2 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm text-center space-y-3">
            <div class="w-12 h-12 mx-auto bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-bullhorn text-lg"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm">Publikasi Mudah</h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                Buat poster, jadwalkan acara, dan jangkau audiens secara efisien.
            </p>
        </div>

        <!-- Kartu 3 -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm text-center space-y-3">
            <div class="w-12 h-12 mx-auto bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-lg"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm">Laporan Rekapitulasi</h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                Dapatkan data pendaftar dengan rapi tanpa perlu rekap manual.
            </p>
        </div>

    </div>

</div>
@endsection