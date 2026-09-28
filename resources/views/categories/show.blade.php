@extends('layouts.app')

@section('content')
<!-- Container Utama dengan Margin Kanan-Kiri 2cm -->
<div class="px-[2cm] py-6 space-y-10">
    @php
        // Master Data Frontend Kategori & Daftar Webinar Lengkap
        $categoriesData = [
            'digital-marketing' => [
                'title' => 'Digital Marketing',
                'desc' => 'Strategi pemasaran digital, SEO, SEM, dan manajemen media sosial.',
                'icon' => 'fa-bullhorn',
                'color' => 'from-blue-600 to-indigo-700',
                'webinars' => [
                    [
                        'title' => 'Mastering Digital Marketing & Growth Hacking 2026', 
                        'speaker' => 'Andi Pratama', 
                        'date' => '25 Okt 2026 • 19.30 WIB', 
                        'price' => 150000
                    ],
                    [
                        'title' => 'Advanced SEO & Content Strategy for Business', 
                        'speaker' => 'Siti Rahma', 
                        'date' => '28 Okt 2026 • 13.00 WIB', 
                        'price' => 0
                    ]
                ]
            ],
            'teknologi-coding' => [
                'title' => 'Teknologi & Coding',
                'desc' => 'Kuasai pemrograman web, aplikasi mobile, cloud computing, dan DevOps.',
                'icon' => 'fa-laptop-code',
                'color' => 'from-indigo-600 to-purple-700',
                'webinars' => []
            ],
            'pengembangan-diri' => [
                'title' => 'Pengembangan Diri',
                'desc' => 'Tingkatkan keterampilan lunak (soft skills) seperti public speaking, kepemimpinan, dan manajemen waktu.',
                'icon' => 'fa-user-check',
                'color' => 'from-emerald-600 to-teal-700',
                'webinars' => [
                    [
                        'title' => 'Public Speaking Mastery: Bicara Percaya Diri di Depan Umum', 
                        'speaker' => 'Budi Santoso', 
                        'date' => '02 Nov 2026 • 10.00 WIB', 
                        'price' => 75000
                    ],
                    [
                        'title' => 'Personal Branding & Professional Communication', 
                        'speaker' => 'Maya Anggraini', 
                        'date' => '05 Nov 2026 • 15.30 WIB', 
                        'price' => 0
                    ]
                ]
            ],
            'bisnis-keuangan' => [
                'title' => 'Bisnis & Keuangan',
                'desc' => 'Pelajari strategi wirausaha, pengelolaan keuangan, investasi, dan perencanaan bisnis.',
                'icon' => 'fa-chart-line',
                'color' => 'from-amber-500 to-orange-600',
                'webinars' => []
            ],
            'desain-uiux' => [
                'title' => 'Desain & UI/UX',
                'desc' => 'Eksplorasi dunia desain grafis, UI/UX research, prototyping, serta desain produk modern.',
                'icon' => 'fa-palette',
                'color' => 'from-purple-600 to-pink-600',
                'webinars' => []
            ],
            'pendidikan-karir' => [
                'title' => 'Pendidikan & Karir',
                'desc' => 'Persiapkan diri menuju dunia kerja, optimasi CV & LinkedIn, persiapan wawancara, serta info beasiswa.',
                'icon' => 'fa-graduation-cap',
                'color' => 'from-rose-600 to-red-600',
                'webinars' => [
                    [
                        'title' => 'Leadership Masterclass: Menjadi Pemimpin Efektif di Era Digital', 
                        'speaker' => 'Hendro Wijaya', 
                        'date' => '18 Oktober 2026 • 19.00 WIB', 
                        'price' => 125000
                    ]
                ]
            ],
            'lainnya' => [
                'title' => 'Lainnya',
                'desc' => 'Berbagai topik menarik dan inspiratif lainnya di luar kategori utama.',
                'icon' => 'fa-cubes',
                'color' => 'from-teal-600 to-cyan-700',
                'webinars' => [
                    [
                        'title' => 'Basic Photography: Teknik Pencahayaan & Komposisi', 
                        'speaker' => 'Reza Artamevia', 
                        'date' => '15 Nov 2026 • 09.00 WIB', 
                        'price' => 50000
                    ],
                    [
                        'title' => 'Content Creator Bootcamp: Dari Hobi Jadi Cuan', 
                        'speaker' => 'Fadli Zon', 
                        'date' => '18 Nov 2026 • 19.00 WIB', 
                        'price' => 100000
                    ],
                    [
                        'title' => 'Financial Freedom for Beginners & Crypto Basics', 
                        'speaker' => 'Denny Sumargo', 
                        'date' => '20 Nov 2026 • 16.00 WIB', 
                        'price' => 0
                    ],
                    [
                        'title' => 'English for Professional Workplace & Interview', 
                        'speaker' => 'Sarah Wijaya', 
                        'date' => '22 Nov 2026 • 13.30 WIB', 
                        'price' => 75000
                    ]
                ]
            ],
        ];

        // Deteksi kategori aktif berdasarkan URL/Slug
        $currentKey = isset($decodedCategory) ? strtolower(str_replace(' ', '-', $decodedCategory)) : 'digital-marketing';
        $categoryInfo = $categoriesData[$currentKey] ?? [
            'title' => $decodedCategory ?? 'Kategori Webinar',
            'desc' => 'Jelajahi berbagai webinar pilihan pada kategori ini.',
            'icon' => 'fa-shapes',
            'color' => 'from-indigo-600 to-purple-700',
            'webinars' => []
        ];

        $webinars = $categoryInfo['webinars'];
    @endphp

    <!-- Navigation Back -->
    <div>
        <a href="{{ route('categories') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-gray-500 hover:text-indigo-600 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Semua Kategori
        </a>
    </div>

    <!-- Banner Header Kategori Spesifik -->
    <div class="bg-gradient-to-r {{ $categoryInfo['color'] }} text-white p-8 md:p-12 rounded-3xl flex justify-between items-center shadow-xl relative overflow-hidden">
        <div class="relative z-10 space-y-3 w-full">
            <span class="inline-block bg-white/25 backdrop-blur-md px-3 py-1 rounded-full text-xs font-medium text-white">
                Kategori Webinar
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ $categoryInfo['title'] }}</h1>
            <p class="text-xs md:text-sm text-white/95 max-w-2xl leading-relaxed">
                {{ $categoryInfo['desc'] }}
            </p>
        </div>
        <div class="hidden md:block pr-6 relative z-10">
            <i class="fas {{ $categoryInfo['icon'] }} text-7xl text-white/20"></i>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- Header List Webinar -->
    <div class="flex justify-between items-center pt-2">
        <div>
            <h2 class="font-bold text-xl text-gray-900">Daftar Webinar {{ $categoryInfo['title'] }}</h2>
            <p class="text-xs text-gray-500 mt-0.5">Menampilkan {{ count($webinars) }} webinar yang tersedia</p>
        </div>
        <select class="border border-gray-200 text-xs rounded-xl px-3 py-2 bg-white text-gray-700 font-medium shadow-sm">
            <option>Urutkan: Terbaru</option>
            <option>Urutkan: Populer</option>
            <option>Urutkan: Harga Terendah</option>
        </select>
    </div>

    <!-- Grid Webinar Frontend -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($webinars as $item)
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition flex flex-col justify-between group">
                <div>
                    <!-- Banner Visual Kartu -->
                    <div class="relative h-40 bg-gradient-to-r {{ $categoryInfo['color'] }} p-4 flex flex-col justify-between text-white overflow-hidden">
                        <span class="text-[10px] bg-white/20 backdrop-blur-md px-2.5 py-1 rounded-full w-fit font-medium relative z-10">
                            {{ $categoryInfo['title'] }}
                        </span>
                        <span class="absolute top-3 right-3 text-white/20 text-4xl">
                            <i class="fas {{ $categoryInfo['icon'] }}"></i>
                        </span>
                    </div>

                    <!-- Detail Info Webinar -->
                    <div class="p-5 space-y-3">
                        <div class="text-xs text-indigo-600 font-medium flex items-center gap-1.5">
                            <i class="far fa-calendar"></i> {{ $item['date'] }}
                        </div>
                        <h3 class="font-bold text-base text-gray-900 group-hover:text-indigo-600 transition line-clamp-2">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-xs text-gray-500 flex items-center gap-1.5">
                            <i class="far fa-user text-indigo-500"></i> {{ $item['speaker'] }}
                        </p>
                    </div>
                </div>

                <!-- Footer Kartu -->
                <div class="px-5 pb-5 pt-3 border-t border-gray-50 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-gray-400 block">Biaya Investasi</span>
                        <p class="font-bold {{ $item['price'] == 0 ? 'text-emerald-600' : 'text-indigo-600' }} text-sm">
                            {{ $item['price'] == 0 ? 'Gratis' : 'Rp ' . number_format($item['price'], 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="#" class="px-4 py-2 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-xl hover:bg-indigo-600 hover:text-white transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm space-y-3">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto text-xl">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Belum Ada Webinar Tersedia</h3>
                <p class="text-xs text-gray-400 max-w-sm mx-auto">
                    Saat ini belum ada jadwal webinar aktif untuk kategori <strong>{{ $categoryInfo['title'] }}</strong>. Silakan cek kategori lainnya.
                </p>
                <div class="pt-2">
                    <a href="{{ route('categories') }}" class="px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-xl hover:bg-indigo-700 transition">
                        Kembali ke Daftar Kategori
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection