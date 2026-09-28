@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center my-12">
    
    <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl animate-pulse">
        <i class="fas fa-clock"></i>
    </div>
    
    <h2 class="text-xl font-bold text-gray-800 mb-2">Menunggu Verifikasi Organizer</h2>
    <p class="text-sm text-gray-600 mb-4">
        Bukti pembayaran Anda telah berhasil diunggah dan sedang diperiksa oleh pihak penyelenggara.
    </p>

    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 text-xs text-indigo-700 mb-6 text-left">
        <p class="font-semibold mb-1"><i class="fas fa-info-circle mr-1"></i> Informasi:</p>
        Jika sudah diverifikasi dan disetujui, e-ticket akan dikirimkan langsung ke akun Anda (dapat diakses melalui menu Tiket Saya).
    </div>
    
    <div>
        <a href="{{ route('home') }}" class="inline-block px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
        </a>
    </div>

</div>
@endsection