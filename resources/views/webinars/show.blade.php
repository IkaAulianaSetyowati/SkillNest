@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
    
    <!-- Breadcrumb Navigation -->
    <nav class="flex text-xs text-gray-500 mb-6 gap-2 items-center">
        <a href="{{ route('home') }}" class="hover:text-indigo-600">Beranda</a>
        <i class="fas fa-chevron-right text-[10px] text-gray-400"></i>
        <a href="{{ route('webinars.index') }}" class="hover:text-indigo-600">Webinar</a>
        <i class="fas fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-gray-800 font-medium truncate max-w-xs">{{ $webinar->title }}</span>
    </nav>

    <!-- Flash Alert Status Pendaftaran -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-2xl flex items-center gap-2 shadow-sm">
            <i class="fas fa-check-circle text-green-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-2xl flex items-center gap-2 shadow-sm">
            <i class="fas fa-exclamation-circle text-red-500 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Grid Container: Detail Kiri & Card Ringkasan Kanan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- SISI KIRI (2 Kolom): Banner, Info Utama, & Deskripsi -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Poster/Banner Gambar -->
            <div class="relative w-full h-64 sm:h-80 md:h-96 bg-gray-900 rounded-3xl overflow-hidden shadow-md">
                @if($webinar->image)
                    <img src="{{ Str::startsWith($webinar->image, 'http') ? $webinar->image : asset('storage/' . $webinar->image) }}" 
                         alt="{{ $webinar->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white p-6 text-center">
                        <div>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-3 inline-block">
                                {{ $webinar->category }}
                            </span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold">{{ $webinar->title }}</h2>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Informasi Header Webinar -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full">
                        {{ $webinar->category }}
                    </span>
                    @if($webinar->is_free || $webinar->price == 0)
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-full flex items-center gap-1">
                            <i class="fas fa-tag text-[10px]"></i> Gratis
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">
                    {{ $webinar->title }}
                </h1>

                <!-- Profil Pemateri / Instructor -->
                <div class="flex items-center gap-4 pt-2 border-t border-gray-100">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 border-2 border-indigo-200 flex items-center justify-center text-indigo-600 font-bold text-lg overflow-hidden shrink-0">
                        {{ strtoupper(substr($webinar->speaker, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Pemateri / Pembicara</p>
                        <h4 class="text-sm font-bold text-gray-900">{{ $webinar->speaker }}</h4>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Webinar -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Webinar</h3>
                    <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $webinar->description }}
                    </div>
                </div>
            </div>

        </div>

        <!-- SISI KANAN (1 Kolom): Card Detail Pelaksanaan & Pendaftaran -->
        <div class="space-y-6 lg:sticky lg:top-24">
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-xl space-y-6">
                <h3 class="text-lg font-extrabold text-gray-900 border-b border-gray-100 pb-3">
                    Detail Pelaksanaan
                </h3>

                <!-- List Informasi Waktu, Tempat, & Kuota -->
                <div class="space-y-4 text-xs">
                    
                    <!-- Tanggal -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <i class="far fa-calendar-alt text-sm"></i>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-medium">Tanggal</span>
                            <span class="font-bold text-gray-800 text-sm">
                                {{ \Carbon\Carbon::parse($webinar->date)->isoFormat('D MMMM YYYY') }}
                            </span>
                        </div>
                    </div>

                    <!-- Waktu -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <i class="far fa-clock text-sm"></i>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-medium">Waktu</span>
                            <span class="font-bold text-gray-800 text-sm">
                                {{ $webinar->time ?? '19:00 WIB' }}
                            </span>
                        </div>
                    </div>

                    <!-- Lokasi / Platform -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <i class="fas fa-video text-sm"></i>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-medium">Platform</span>
                            <span class="font-bold text-gray-800 text-sm">
                                Zoom Meeting
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Price Tag -->
                <div class="bg-slate-50 p-4 rounded-2xl border border-gray-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500">Biaya Pendaftaran</span>
                    <span class="text-xl font-extrabold text-indigo-600">
                        @if($webinar->is_free || $webinar->price == 0)
                            GRATIS
                        @else
                            Rp {{ number_format($webinar->price, 0, ',', '.') }}
                        @endif
                    </span>
                </div>

                <!-- Action Button Form -->
                <div class="space-y-3">
                    @auth
                        @if(isset($isRegistered) && $isRegistered)
                            <button disabled class="w-full py-3.5 bg-emerald-100 text-emerald-700 font-bold text-xs uppercase tracking-wider rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle text-sm"></i> Anda Sudah Terdaftar
                            </button>
                        @else
                            <form id="registerForm" action="{{ route('webinars.register', $webinar->id) }}" method="POST">
                                @csrf
                                <button type="button" 
                                        id="btnRegister"
                                        onclick="confirmRegistration()"
                                        class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-indigo-200 transition duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-ticket-alt"></i> Daftar Webinar Sekarang
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-indigo-200 transition duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt"></i> Masuk untuk Mendaftar
                        </a>
                    @endauth

                    <button type="button" 
                            id="btnWishlist"
                            onclick="toggleWishlist()"
                            class="w-full py-2.5 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition flex items-center justify-center gap-1.5">
                        <i id="wishlistIcon" class="far fa-bookmark text-indigo-500"></i> <span id="wishlistText">Tambah ke Wishlist</span>
                    </button>
                </div>

                <p class="text-[11px] text-center text-gray-400">
                    Link room akan dikirimkan ke email kamu setelah pendaftaran berhasil.
                </p>

            </div>
        </div>

    </div>
</main>

<!-- Modal Konfirmasi Pendaftaran -->
<div id="confirmModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-300" id="modalCard">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
            <i class="fas fa-question text-indigo-600"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Konfirmasi Pendaftaran</h3>
        <p class="text-xs text-gray-600 text-center mb-6 leading-relaxed">
            Apakah Anda yakin ingin mendaftar ke webinar <span class="font-semibold text-gray-800">"{{ $webinar->title }}"</span>?
        </p>
        <div class="flex gap-3">
            <button onclick="closeModal()" class="flex-1 py-3 border border-gray-200 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                Batal
            </button>
            <button onclick="submitForm()" class="flex-1 py-3 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 shadow-md transition">
                Ya, Mendaftar
            </button>
        </div>
    </div>
</div>

<script>
    function confirmRegistration() {
        const modal = document.getElementById('confirmModal');
        const modalCard = document.getElementById('modalCard');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('confirmModal');
        const modalCard = document.getElementById('modalCard');
        modalCard.classList.remove('scale-100');
        modalCard.classList.add('scale-95');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function submitForm() {
        document.getElementById('registerForm').submit();
    }

    let isWishlisted = false;
    function toggleWishlist() {
        isWishlisted = !isWishlisted;
        const icon = document.getElementById('wishlistIcon');
        const text = document.getElementById('wishlistText');
        
        if (isWishlisted) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            text.innerText = 'Tersimpan di Wishlist';
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            text.innerText = 'Tambah ke Wishlist';
        }
    }
</script>
@endsection