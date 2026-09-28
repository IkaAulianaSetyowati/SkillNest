@extends('layouts.app')

@section('content')
<main class="max-w-lg mx-auto px-4 py-16 text-center">
    <div class="bg-white p-10 rounded-3xl border border-gray-100 shadow-sm space-y-5">
        <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto text-2xl">
            <i class="fas fa-hourglass-half"></i>
        </div>
        <h1 class="text-xl font-extrabold text-gray-900">Menunggu Verifikasi</h1>
        <p class="text-sm text-gray-500 leading-relaxed">
            Bukti pembayaran Anda untuk webinar <span class="font-semibold text-gray-800">{{ $registration->webinar->judul }}</span>
            sedang diverifikasi oleh penyelenggara. Proses ini biasanya memakan waktu 1x24 jam.
        </p>
        <p class="text-xs text-gray-400">Kode pendaftaran: {{ $registration->registration_code }}</p>

        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
            Kembali ke Beranda
        </a>
    </div>
</main>
@endsection