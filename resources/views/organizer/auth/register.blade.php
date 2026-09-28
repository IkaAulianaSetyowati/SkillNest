@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-10 bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Daftar Akun Organizer</h2>
        <p class="text-xs text-gray-500 mt-1">Lengkapi data diri dan syarat di bawah untuk verifikasi akun Anda.</p>
    </div>

    <!-- Pesan Error Validasi -->
    @if ($errors->any())
        <div class="mb-4 p-3.5 bg-red-50/80 border border-red-100 rounded-xl text-xs text-red-600 space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-1.5"><i class="fas fa-exclamation-circle text-red-500"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('organizer.register') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Nama Organizer -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Organisasi / Organizer</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: SkillNest Official">
        </div>

        <!-- Nama Pemilik Akun -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Pemilik Akun</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nama lengkap Anda">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Aktif</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="email@domain.com">
        </div>

        <!-- No Telepon / WhatsApp -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nomor WhatsApp / Telepon</label>
            <input type="text" name="telepon" value="{{ old('telepon') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="08xxxxxxxxxx">
        </div>

        <!-- Password -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Password</label>
            <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Min. 8 karakter, huruf & angka">
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ulangi password">
        </div>

        <!-- Upload Dokumen Verifikasi -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Dokumen Verifikasi (KTP / NPWP / Legalitas)</label>
            <input type="file" name="dokumen" required accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
            <p class="text-[11px] text-gray-400 mt-1">Format PDF, JPG, atau PNG. Maksimal 2MB.</p>
        </div>

        <!-- Syarat & Ketentuan / Catatan Verifikasi -->
        <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100 text-xs text-indigo-700 space-y-1">
            <p class="font-bold">Ketentuan Organizer:</p>
            <p>Akun yang didaftarkan akan melalui proses peninjauan (verifikasi) oleh Admin sebelum dapat membuat dan mempublikasikan webinar.</p>
        </div>

        <!-- Checkbox Persetujuan -->
        <label class="flex items-start gap-2 text-xs text-gray-600 cursor-pointer select-none">
            <input type="checkbox" name="setuju" value="1" required class="mt-0.5 w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <span>Saya menyatakan data dan dokumen yang saya kirim benar.</span>
        </label>

        <!-- Tombol Submit -->
        <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-indigo-700 transition-colors shadow-md">
            Daftar & Kirim Verifikasi
        </button>
    </form>

    <p class="text-center text-xs text-gray-500 mt-5">
        Sudah punya akun organizer? <a href="{{ route('organizer.login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 transition">Masuk di sini</a>
    </p>
</div>
@endsection