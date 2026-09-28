@extends('layouts.app')

@section('content')
<div class="space-y-10">

    <!-- Breadcrumb Navigasi -->
    <nav class="flex text-xs text-gray-500 space-x-2">
        <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="hover:text-indigo-600 transition">Beranda</a>
        <span>/</span>
        <a href="{{ Route::has('webinars.index') ? route('webinars.index') : '#' }}" class="hover:text-indigo-600 transition">Webinar</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold truncate">{{ $webinar->title ?? 'Detail Webinar' }}</span>
    </nav>

    <!-- Layout Utama: Grid 2 Kolom (Kiri Content Utama, Kanan Card Pendaftaran) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

        <!-- Kolom Kiri: Header, Poster, Deskripsi, Pembicara, Agenda -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Title & Kategori Banner -->
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 font-semibold text-xs rounded-full border border-indigo-100">
                        {{ $webinar->category->name ?? 'Teknologi & Desain' }}
                    </span>
                    <span class="text-xs text-gray-400 flex items-center gap-1">
                        <i class="far fa-eye"></i> {{ $webinar->views ?? '1,250' }} Dilihat
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-snug">
                    {{ $webinar->title ?? 'Mastering UI/UX Design: Dari Riset Pengguna Hingga Prototyping Interaktif' }}
                </h1>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Diselenggarakan oleh <span class="font-semibold text-indigo-600">{{ $webinar->organizer->name ?? 'SkillNest Academy' }}</span>
                </p>
            </div>

            <!-- Banner / Poster Webinar -->
            <div class="relative w-full h-64 md:h-96 rounded-2xl overflow-hidden shadow-md bg-gray-100">
                <img 
                    src="{{ isset($webinar->banner) ? asset('storage/' . $webinar->banner) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1200&auto=format&fit=crop' }}" 
                    alt="{{ $webinar->title ?? 'Banner Webinar' }}" 
                    class="w-full h-full object-cover"
                >
            </div>

            <!-- Informasi Detail Ringkas (Waktu, Mode, Sertifikat, Bahasa) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-5 bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="space-y-1">
                    <p class="text-xs text-gray-400 font-medium">Tanggal & Waktu</p>
                    <p class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="far fa-calendar-alt text-indigo-600"></i>
                        <span>{{ isset($webinar->date) ? \Carbon\Carbon::parse($webinar->date)->translatedFormat('d M Y, H:i') . ' WIB' : '25 Sep 2026, 19:00 WIB' }}</span>
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs text-gray-400 font-medium">Platform</p>
                    <p class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="fas fa-video text-indigo-600"></i>
                        <span>{{ $webinar->platform ?? 'Zoom Meeting' }}</span>
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs text-gray-400 font-medium">Fasilitas</p>
                    <p class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="fas fa-certificate text-indigo-600"></i>
                        <span>E-Sertifikat</span>
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs text-gray-400 font-medium">Bahasa</p>
                    <p class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="fas fa-globe text-indigo-600"></i>
                        <span>Bahasa Indonesia</span>
                    </p>
                </div>
            </div>

            <!-- Deskripsi Webinar -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Deskripsi Webinar</h3>
                <div class="text-xs md:text-sm text-gray-600 leading-relaxed space-y-3">
                    {!! $webinar->description ?? '
                        <p>Webinar ini dirancang khusus untuk Kamu yang ingin mendalami dunia UI/UX Design secara praktis dan terstruktur. Dalam sesi ini, pembicara akan membagikan metodologi riset pengguna modern, teknik menyusun user flow yang intuitif, serta pembuatan kerangka kerja wireframe dan prototype interaktif menggunakan Figma.</p>
                        <p>Selain pemaparan materi, peserta juga akan diajak langsung dalam sesi live demo dan studi kasus proyek nyata di industri digital saat ini.</p>
                    ' !!}
                </div>
            </div>

            <!-- Pembicara / Speaker -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Pembicara</h3>
                <div class="flex items-center gap-4">
                    <img 
                        src="{{ isset($webinar->speaker_avatar) ? asset('storage/' . $webinar->speaker_avatar) : 'https://ui-avatars.com/api/?name=Alex+Pratama&background=4F46E5&color=fff' }}" 
                        alt="Pembicara" 
                        class="w-16 h-16 rounded-full object-cover border-2 border-indigo-600 shadow-sm"
                    >
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">{{ $webinar->speaker_name ?? 'Alex Pratama, S.Kom.' }}</h4>
                        <p class="text-xs text-indigo-600 font-medium">{{ $webinar->speaker_title ?? 'Senior Product Designer di TechCorp' }}</p>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                            {{ $webinar->speaker_bio ?? 'Berpengalaman lebih dari 7 tahun membangun produk digital berskala jutaan pengguna aktif harian.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Agenda / Jadwal Acara -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Agenda Acara</h3>
                <ul class="space-y-3 text-xs md:text-sm text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 font-bold text-xs rounded-md">19:00 - 19:15</span>
                        <span>Pembukaan & Sambutan Organizer</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 font-bold text-xs rounded-md">19:15 - 20:15</span>
                        <span>Pemaparan Materi & Live Demo Prototyping</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 font-bold text-xs rounded-md">20:15 - 20:45</span>
                        <span>Sesi Tanya Jawab (Q&A) Interaktif</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 font-bold text-xs rounded-md">20:45 - 21:00</span>
                        <span>Foto Bersama, Kesimpulan & Pembagian E-Sertifikat</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Kolom Kanan: Card Pendaftaran / Sticky Sidebar -->
        <div class="space-y-6 lg:sticky lg:top-24">
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-md space-y-6">
                <!-- Harga -->
                <div>
                    <span class="text-xs text-gray-400 font-medium">Investasi / Harga</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-3xl font-extrabold text-indigo-600">
                            {{ isset($webinar->price) && $webinar->price > 0 ? 'Rp ' . number_format($webinar->price, 0, ',', '.') : 'GRATIS' }}
                        </span>
                        @if(isset($webinar->original_price) && $webinar->original_price > $webinar->price)
                            <span class="text-sm text-gray-400 line-through">Rp {{ number_format($webinar->original_price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Fitur yang didapatkan -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Benefit Webinar</h4>
                    <ul class="space-y-2 text-xs text-gray-600">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>Akses Sesi Live & Diskusi</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>E-Sertifikat Resmi</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>Modul & File Material Proyek</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>Rekaman Ulang Sesi</span>
                        </li>
                    </ul>
                </div>

                <!-- Tombol Aksi (Daftar / Wishlist) -->
                <div class="space-y-3 pt-2">
                    <a href="{{ Route::has('webinars.register') ? route('webinars.register', $webinar->id ?? 1) : '#' }}" class="w-full block text-center py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg transition">
                        Daftar Sekarang
                    </a>

                    <button type="button" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold text-xs rounded-xl border border-gray-200 transition">
                        <i class="far fa-heart text-indigo-600"></i>
                        <span>Tambah ke Wishlist</span>
                    </button>
                </div>

                <!-- Kuota Tersisa -->
                <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 text-center">
                    <p class="text-xs text-amber-700 font-medium">
                        <i class="fas fa-fire mr-1 text-amber-500"></i> Kuota Terbatas! Tersisa <span class="font-bold">{{ $webinar->quota_left ?? '18' }} kursi</span> lagi.
                    </p>
                </div>
            </div>

            <!-- Card Bagikan Webinar -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-3">
                <h4 class="text-xs font-bold text-gray-800">Bagikan Webinar Ini</h4>
                <div class="flex items-center space-x-2">
                    <a href="#" class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-center text-gray-500 text-xs transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-center text-gray-500 text-xs transition">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-center text-gray-500 text-xs transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <button type="button" class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-center text-gray-500 text-xs transition" title="Salin Link">
                        <i class="far fa-copy"></i>
                    </button>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection