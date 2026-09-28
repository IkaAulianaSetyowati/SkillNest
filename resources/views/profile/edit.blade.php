@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
    
    <!-- Title Section -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
            {{ $user->role === 'organizer' ? 'Profil & Data Organizer' : 'Profil Saya' }}
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
            {{ $user->role === 'organizer' ? 'Kelola informasi instansi dan data profil penyelenggara webinar.' : 'Kelola informasi akun dan lihat daftar webinar yang kamu ikuti.' }}
        </p>
    </div>

    <!-- Alert Status -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-2xl flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 {{ $user->role === 'organizer' ? 'lg:grid-cols-1 max-w-3xl' : 'lg:grid-cols-3' }} gap-8 items-start">
        
        <!-- SISI KIRI: Form Edit Profil -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
            <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Informasi Akun</h2>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Preview & Upload Avatar -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 rounded-full bg-indigo-100 border-2 border-indigo-200 flex items-center justify-center text-indigo-600 font-bold text-xl overflow-hidden shrink-0">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            {{ $user->role === 'organizer' ? 'Logo Instansi / Foto Profil' : 'Foto Profil' }}
                        </label>
                        <input type="file" name="avatar" class="text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        {{ $user->role === 'organizer' ? 'Nama Instansi / Penyelenggara' : 'Nama Lengkap' }}
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-2.5 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-indigo-500 transition">
                    @error('name') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-2.5 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-indigo-500 transition">
                    @error('email') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                </div>

                @if($user->role === 'organizer')
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi / Bio Organizer</label>
                        <textarea name="bio" rows="3" placeholder="Jelaskan mengenai instansi atau profil penyelenggara Anda..."
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-indigo-500 transition">{{ old('bio', $user->bio ?? '') }}</textarea>
                        @error('bio') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="border-t border-gray-100 pt-4 space-y-4">
                    <p class="text-xs font-semibold text-gray-500">Ubah Password (Opsional)</p>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-indigo-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-indigo-500 transition">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- SISI KANAN (2 Kolom): Daftar Webinar Terdaftar (Hanya Tampil Jika BUKAN Organizer) -->
        @if($user->role !== 'organizer')
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h2 class="text-lg font-bold text-gray-900">Webinar Terdaftar</h2>
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full">
                            {{ isset($registrations) ? $registrations->count() : 0 }} Webinar
                        </span>
                    </div>

                    @forelse($registrations ?? [] as $registration)
                        <div class="p-4 rounded-2xl border border-gray-100 hover:border-indigo-200 transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-slate-50/50">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-200 shrink-0">
                                    @if($registration->webinar->image)
                                        <img src="{{ Str::startsWith($registration->webinar->image, 'http') ? $registration->webinar->image : asset('storage/' . $registration->webinar->image) }}" 
                                             alt="{{ $registration->webinar->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold">
                                            Webinar
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase text-indigo-600 tracking-wider">
                                        {{ $registration->webinar->category }}
                                    </span>
                                    <h3 class="text-sm font-bold text-gray-900 leading-snug">
                                        {{ $registration->webinar->title }}
                                    </h3>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                        <span><i class="far fa-user text-indigo-500 mr-1"></i> {{ $registration->webinar->speaker }}</span>
                                        <span><i class="far fa-calendar text-indigo-500 mr-1"></i> {{ \Carbon\Carbon::parse($registration->webinar->date)->isoFormat('D MMM YYYY') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 w-full sm:w-auto justify-end border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 font-semibold text-[11px] rounded-full">
                                    Terdaftar
                                </span>
                                <a href="{{ route('webinars.show', $registration->webinar->id) }}" class="px-3 py-1.5 bg-indigo-600 text-white font-medium text-xs rounded-lg hover:bg-indigo-700 transition">
                                    Lihat
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 space-y-3">
                            <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto text-2xl">
                                <i class="far fa-calendar-times"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-700">Belum Ada Webinar yang Diikuti</h4>
                            <p class="text-xs text-gray-400 max-w-sm mx-auto">Kamu belum mendaftar di webinar manapun. Yuk, jelajahi webinar menarik yang tersedia!</p>
                            <a href="{{ route('webinars.index') }}" class="inline-block mt-2 px-5 py-2.5 bg-indigo-600 text-white font-semibold text-xs rounded-xl hover:bg-indigo-700 transition">
                                Cari Webinar
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

    </div>
</main>
@endsection