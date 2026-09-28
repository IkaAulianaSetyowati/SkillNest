@extends('layouts.app')

@section('content')
@php
    // Jika $featuredWebinars dari controller kosong, gunakan data dummy frontend
    if (!isset($featuredWebinars) || count($featuredWebinars) == 0) {
        $featuredWebinars = [
            (object)[
                'id' => 3,
                'judul' => 'Digital Marketing untuk Pemula',
                'speaker' => 'Hendro Wijaya',
                'kategori_id' => 13,
                'nama_kategori' => 'DIGITAL MARKETING',
                'tanggal' => '2026-09-12',
                'waktu' => '14:00:00',
                'harga' => 150000,
                'banner' => 'banners/digital-marketing.png'
            ],
            (object)[
                'id' => 4,
                'judul' => 'Web Development JavaScript',
                'speaker' => 'Kevin Wicaksana',
                'kategori_id' => 12,
                'nama_kategori' => 'TEKNOLOGI & PEMROGRAMAN',
                'tanggal' => '2026-09-15',
                'waktu' => '14:00:00',
                'harga' => 0,
                'banner' => 'banners/web.png'
            ],
            (object)[
                'id' => 5,
                'judul' => 'Manajemen Keuangan Pribadi',
                'speaker' => 'Budi Santoso',
                'kategori_id' => 10,
                'nama_kategori' => 'BISNIS & KEUANGAN',
                'tanggal' => '2026-09-18',
                'waktu' => '10:00:00',
                'harga' => 100000,
                'banner' => 'banners/keuangan.png'
            ],
            (object)[
                'id' => 6,
                'judul' => 'Career Preparation: CV & Interview',
                'speaker' => 'Siti Rahmawati',
                'kategori_id' => 8,
                'nama_kategori' => 'PENDIDIKAN & KARIER',
                'tanggal' => '2026-09-20',
                'waktu' => '15:00:00',
                'harga' => 0,
                'banner' => 'banners/karir.png'
            ]
        ];
    }
@endphp

<div class="bg-white w-full rounded-2xl py-8 px-8">
    
    <!-- ================= 1. HERO SECTION ================= -->
    <section class="w-full pb-16 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <!-- Sisi Kiri (Teks & Tombol) -->
        <div class="lg:col-span-6 space-y-6">
            <span class="inline-block px-3.5 py-1.5 bg-indigo-50 text-indigo-600 font-semibold text-xs rounded-full">
                {{ __('messages.badge_trusted') }}
            </span>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 leading-tight tracking-tight">
                {{ __('messages.hero_title_1') }}<br>
                <span class="text-indigo-600">{{ __('messages.hero_title_2') }}</span>
            </h1>

            <p class="text-gray-500 text-sm sm:text-base leading-relaxed max-w-xl">
                {{ __('messages.hero_subtitle') }}
            </p>

            <!-- Tombol Aksi -->
            <div class="flex items-center gap-4 pt-2">
                <a href="{{ Route::has('webinars.index') ? route('webinars.index') : '#' }}" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-200 transition">
                    {{ __('messages.btn_explore') }}
                </a>
                <a href="{{ Route::has('organizer.landing') ? route('organizer.landing') : '#' }}" class="px-8 py-3.5 border border-indigo-600 text-indigo-600 hover:bg-indigo-50 text-sm font-semibold rounded-xl transition">
                    {{ __('messages.btn_organizer') }}
                </a>
            </div>

            <!-- Fitur Utama -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-8 border-t border-gray-100">
                <div class="flex flex-col items-center text-center p-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs mb-2">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-xs">{{ __('messages.feature_quality') }}</h4>
                        <p class="text-[10px] text-gray-400 leading-tight">{{ __('messages.feature_quality_desc') }}</p>
                    </div>
                </div>

                <div class="flex flex-col items-center text-center p-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs mb-2">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-xs">{{ __('messages.feature_cert') }}</h4>
                        <p class="text-[10px] text-gray-400 leading-tight">{{ __('messages.feature_cert_desc') }}</p>
                    </div>
                </div>

                <div class="flex flex-col items-center text-center p-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs mb-2">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-xs">{{ __('messages.feature_flexible') }}</h4>
                        <p class="text-[10px] text-gray-400 leading-tight">{{ __('messages.feature_flexible_desc') }}</p>
                    </div>
                </div>

                <div class="flex flex-col items-center text-center p-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs mb-2">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-xs">{{ __('messages.feature_community') }}</h4>
                        <p class="text-[10px] text-gray-400 leading-tight">{{ __('messages.feature_community_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Gambar & Stats -->
        <div class="lg:col-span-6 relative flex justify-center items-center mt-6 lg:mt-0">
            <div class="absolute w-[85%] h-[85%] bg-indigo-200/60 rounded-full blur-2xl -z-10 transform translate-x-2 translate-y-2"></div>
            
            <div class="absolute top-8 left-10 w-3 h-3 rounded-full bg-indigo-400/70"></div>
            <div class="absolute top-16 right-6 w-2.5 h-2.5 rounded-full bg-indigo-500/70"></div>
            <div class="absolute bottom-16 left-6 w-4 h-4 rounded-full bg-purple-400/70"></div>
            <div class="absolute bottom-8 right-12 w-3 h-3 rounded-full bg-indigo-300"></div>

            <!-- Badge Statistics 1 -->
            <div class="absolute top-6 left-0 sm:left-4 bg-white/95 backdrop-blur-md p-3 rounded-2xl shadow-xl border border-gray-100 flex items-center gap-3 z-20">
                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xs">
                    12K+
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-900">{{ __('messages.webinar_available') }}</p>
                    <p class="text-[10px] text-gray-400">{{ __('messages.webinar_ready') }}</p>
                </div>
            </div>

            <!-- Badge Statistics 2 -->
            <div class="absolute bottom-12 right-0 sm:right-4 bg-white/95 backdrop-blur-md p-3 rounded-2xl shadow-xl border border-gray-100 flex items-center gap-3 z-20">
                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xs">
                    98%
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-900">{{ __('messages.participant_satisfaction') }}</p>
                    <p class="text-[10px] text-gray-400">{{ __('messages.satisfaction_rate') }}</p>
                </div>
            </div>

            <img 
                src="{{ asset('images/orang.png') }}" 
                alt="SkillNest Student" 
                class="w-full max-w-lg object-contain relative z-10 drop-shadow-sm"
                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80';"
            >
        </div>
    </section>

    <!-- ================= 2. SECTION WEBINAR POPULER ================= -->
    <section class="w-full py-12 border-t border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ __('messages.section_webinar_title') }}</h2>
                <p class="text-xs text-gray-500 mt-1">{{ __('messages.section_webinar_subtitle') }}</p>
            </div>
            <a href="{{ Route::has('webinars.index') ? route('webinars.index') : '#' }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition">
                {{ __('messages.see_all') }} &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($featuredWebinars as $item)
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition flex flex-col justify-between">
                    <div>
                        <div class="relative h-44 bg-indigo-900">
                            @php
                                $imagePath = $item->banner ?? null;
                                
                                if ($imagePath) {
                                    $finalImage = Str::startsWith($imagePath, ['http://', 'https://']) 
                                        ? $imagePath 
                                        : asset('storage/' . $imagePath);
                                } else {
                                    $finalImage = 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=600&q=80';
                                }
                            @endphp

                            <img src="{{ $finalImage }}" class="w-full h-full object-cover opacity-80" alt="{{ $item->judul ?? $item->title ?? '' }}">

                            <!-- BADGE KATEGORI DI POJOK KIRI ATAS BANNER -->
                            <span class="absolute top-3 left-3 bg-indigo-600/90 backdrop-blur-sm text-white text-[10px] font-semibold px-2.5 py-1 rounded-md uppercase tracking-wider">
                                {{ 
                                    $item->nama_kategori 
                                    ?? optional($item->category)->name 
                                    ?? optional($item->kategori)->nama 
                                    ?? ('Kategori #' . ($item->kategori_id ?? 'Umum')) 
                                }}
                            </span>
                        </div>
                        
                        <!-- DETAIL WEBINAR DI LUAR BANNER (JUDUL UTAMA) -->
                        <div class="p-4 space-y-3">
                            <h3 class="font-bold text-gray-900 text-sm leading-snug line-clamp-2">
                                {{ $item->judul ?? $item->title ?? '-' }}
                            </h3>

                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->speaker ?? 'Speaker') }}&background=4F46E5&color=fff" class="w-5 h-5 rounded-full" alt="{{ $item->speaker ?? 'Speaker' }}">
                                <span class="text-xs text-gray-600 font-medium">{{ $item->speaker ?? __('messages.speaker_default') }}</span>
                            </div>
                            
                            <!-- TANGGAL DAN JAM -->
                            <div class="text-xs text-gray-500 space-y-1">
                                <p>
                                    <i class="far fa-calendar mr-1.5 text-indigo-500"></i> 
                                    {{ isset($item->tanggal) ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '-' }}
                                </p>
                                <p>
                                    <i class="far fa-clock mr-1.5 text-indigo-500"></i> 
                                    {{ isset($item->waktu) ? \Carbon\Carbon::parse($item->waktu)->format('H.i') . ' WIB' : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- HARGA -->
                    <div class="p-4 pt-0 border-t border-gray-50 mt-2 flex items-center justify-between">
                        <div>
                            @php
                                $hargaItem = $item->harga ?? $item->price ?? 0;
                                $regularPrice = $hargaItem > 0 ? $hargaItem * 1.5 : 100000;
                            @endphp
                            <span class="text-[10px] text-gray-400 line-through">
                                {{ $hargaItem == 0 ? 'Rp 100.000' : 'Rp ' . number_format($regularPrice, 0, ',', '.') }}
                            </span>
                            <p class="font-bold {{ $hargaItem == 0 ? 'text-emerald-600' : 'text-indigo-600' }} text-sm">
                                {{ $hargaItem == 0 ? __('messages.free') : 'Rp ' . number_format($hargaItem, 0, ',', '.') }}
                            </p>
                        </div>
                        <a href="{{ Route::has('webinars.show') ? route('webinars.show', $item->id ?? 1) : '#' }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-100 transition">
                            {{ __('messages.detail') }}
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-8 text-gray-400 text-xs">
                    {{ __('messages.no_featured_webinar') }}
                </div>
            @endforelse
        </div>
    </section>

    <!-- ================= 3. SECTION ALASAN MEMILIH SKILLNEST ================= -->
    <section class="w-full my-12">
        <div class="bg-indigo-900 text-white rounded-3xl py-16 px-8 sm:px-10 text-center space-y-12">
            <div class="max-w-2xl mx-auto space-y-2">
                <h2 class="text-3xl font-extrabold">{{ __('messages.why_title') }}</h2>
                <p class="text-xs text-indigo-200">{{ __('messages.why_subtitle') }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                <!-- Card 1 -->
                <div class="bg-white/10 p-8 rounded-2xl backdrop-blur-md border border-white/10 text-center flex flex-col items-center justify-center space-y-4 w-full h-full min-h-[220px]">
                    <div class="w-12 h-12 bg-indigo-500/30 rounded-xl flex items-center justify-center text-indigo-200 text-xl font-bold flex-shrink-0">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-bold text-base">{{ __('messages.why_cert_title') }}</h3>
                        <p class="text-xs text-indigo-200 leading-relaxed">{{ __('messages.why_cert_desc') }}</p>
                    </div>
                </div>
                
                <!-- Card 2 -->
                <div class="bg-white/10 p-8 rounded-2xl backdrop-blur-md border border-white/10 text-center flex flex-col items-center justify-center space-y-4 w-full h-full min-h-[220px]">
                    <div class="w-12 h-12 bg-indigo-500/30 rounded-xl flex items-center justify-center text-indigo-200 text-xl font-bold flex-shrink-0">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-bold text-base">{{ __('messages.why_speaker_title') }}</h3>
                        <p class="text-xs text-indigo-200 leading-relaxed">{{ __('messages.why_speaker_desc') }}</p>
                    </div>
                </div>
                
                <!-- Card 3 -->
                <div class="bg-white/10 p-8 rounded-2xl backdrop-blur-md border border-white/10 text-center flex flex-col items-center justify-center space-y-4 w-full h-full min-h-[220px]">
                    <div class="w-12 h-12 bg-indigo-500/30 rounded-xl flex items-center justify-center text-indigo-200 text-xl font-bold flex-shrink-0">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-bold text-base">{{ __('messages.why_record_title') }}</h3>
                        <p class="text-xs text-indigo-200 leading-relaxed">{{ __('messages.why_record_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection