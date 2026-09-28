<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SkillNest - Platform Webinar') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 w-full px-8 py-4 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center space-x-8">
            <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="flex items-center gap-2 text-2xl font-bold text-indigo-600">
                <img src="{{ asset('images/LOGO SKILLNEST.png') }}" alt="SkillNest Logo" class="h-8 w-auto" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=SN&background=4F46E5&color=fff';">
                <span>SkillNest</span>
            </a>
            <div class="hidden md:flex space-x-6 font-medium text-sm text-gray-600">
                <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="{{ request()->routeIs('home') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">{{ __('messages.nav_home') ?? 'Beranda' }}</a>
                <a href="{{ Route::has('webinars.index') ? route('webinars.index') : '#' }}" class="{{ request()->routeIs('webinars*') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">{{ __('messages.nav_webinar') ?? 'Webinar' }}</a>
                <a href="{{ Route::has('categories.index') ? route('categories.index') : (Route::has('categories') ? route('categories') : '#') }}" class="{{ request()->routeIs('categories*') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">{{ __('messages.nav_category') ?? 'Kategori' }}</a>
                <a href="{{ Route::has('organizer.landing') ? route('organizer.landing') : '#' }}" class="{{ request()->routeIs('organizer*') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">{{ __('messages.nav_organizer') ?? 'Untuk Penyelenggara' }}</a>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Form Pencarian Navbar -->
            <form action="{{ Route::has('webinars.index') ? route('webinars.index') : '#' }}" method="GET" class="relative w-64 hidden lg:block">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="{{ __('messages.search_placeholder') ?? 'Cari webinar, topik...' }}" 
                    class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                <button type="submit" class="absolute left-3 top-2.5 text-gray-400 hover:text-indigo-600">
                    <i class="fas fa-search text-sm"></i>
                </button>
            </form>

            <!-- Dropdown Titik Tiga -->
            <div x-data="{ open: false, langOpen: false }" class="relative z-50">
                <button @click="open = !open" type="button" class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition focus:outline-none">
                    <i class="fas fa-ellipsis-v text-sm"></i>
                </button>

                <div x-show="open" 
                     @click.outside="open = false; langOpen = false" 
                     x-transition 
                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-[9999]">
                    
                    <a href="{{ Route::has('history.index') ? route('history.index') : '#' }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                        <i class="fas fa-history text-indigo-500 text-sm w-4"></i>
                        <span>{{ __('messages.menu_history') ?? 'Riwayat' }}</span>
                    </a>
                    
                    <a href="{{ Route::has('tickets.index') ? route('tickets.index') : '#' }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                        <i class="fas fa-ticket-alt text-indigo-500 text-sm w-4"></i>
                        <span>{{ __('messages.menu_tickets') ?? 'Tiket Saya' }}</span>
                    </a>

                    <a href="{{ Route::has('wishlist.index') ? route('wishlist.index') : '#' }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                        <i class="fas fa-heart text-indigo-500 text-sm w-4"></i>
                        <span>Wishlist</span>
                    </a>

                    <a href="{{ Route::has('schedule.index') ? route('schedule.index') : '#' }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                        <i class="fas fa-calendar-alt text-indigo-500 text-sm w-4"></i>
                        <span>{{ __('messages.menu_schedule') ?? 'Jadwal Webinar' }}</span>
                    </a>

                    <hr class="my-1.5 border-gray-100">

                    <!-- Pilihan Bahasa Manual (ID / EN) -->
                    <div>
                        <button @click="langOpen = !langOpen" type="button" class="w-full flex items-center justify-between px-4 py-2.5 text-xs font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition focus:outline-none">
                            <span class="flex items-center gap-3">
                                <i class="fas fa-globe text-indigo-500 text-sm w-4"></i>
                                <span>{{ __('messages.language') ?? 'Bahasa' }} ({{ strtoupper(app()->getLocale()) }})</span>
                            </span>
                            <i class="fas text-[10px] text-gray-400" :class="langOpen ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>

                        <div x-show="langOpen" x-transition class="bg-gray-50 py-1 border-t border-b border-gray-100">
                            @if(Route::has('lang.switch'))
                                <a href="{{ route('lang.switch', 'id') }}" class="w-full text-left pl-11 pr-4 py-2 text-xs {{ app()->getLocale() == 'id' ? 'font-bold text-indigo-600 bg-indigo-50/60' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50/50' }} flex items-center justify-between transition">
                                    <span>Bahasa Indonesia</span>
                                    @if(app()->getLocale() == 'id') <i class="fas fa-check text-[10px]"></i> @endif
                                </a>
                                <a href="{{ route('lang.switch', 'en') }}" class="w-full text-left pl-11 pr-4 py-2 text-xs {{ app()->getLocale() == 'en' ? 'font-bold text-indigo-600 bg-indigo-50/60' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50/50' }} flex items-center justify-between transition">
                                    <span>English</span>
                                    @if(app()->getLocale() == 'en') <i class="fas fa-check text-[10px]"></i> @endif
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- Autentikasi -->
            @auth
                <div x-data="{ userOpen: false }" class="relative z-50">
                    <button @click="userOpen = !userOpen" type="button" class="flex items-center gap-2 focus:outline-none">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=4F46E5&color=fff' }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="w-10 h-10 rounded-full object-cover border-2 border-indigo-600 hover:opacity-90 transition shadow-sm">
                    </button>

                    <div x-show="userOpen" 
                         @click.outside="userOpen = false" 
                         x-transition 
                         class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-[9999]">
                        
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Menu Khusus Organizer -->
                        @if(Auth::user()->role === 'organizer')
                            <a href="{{ url('/organizer') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-indigo-600 hover:bg-indigo-50 transition">
                                <i class="fas fa-tachometer-alt text-indigo-500 w-4"></i>
                                <span>{{ __('messages.organizer_dashboard') ?? 'Dashboard Organizer' }}</span>
                            </a>
                            <hr class="my-1 border-gray-100">
                        @endif

                        <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                            <i class="fas fa-user text-indigo-500 w-4"></i>
                            <span>{{ __('messages.profile') ?? 'Profil Saya' }}</span>
                        </a>

                        <hr class="my-1 border-gray-100">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs font-medium text-red-600 hover:bg-red-50 transition text-left">
                                <i class="fas fa-sign-out-alt text-red-500 w-4"></i>
                                <span>{{ __('messages.logout') ?? 'Keluar' }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ Route::has('login') ? route('login') : '#' }}" class="px-5 py-2 text-sm font-semibold border border-gray-300 rounded-lg hover:bg-gray-50 transition">{{ __('messages.login') ?? 'Masuk' }}</a>
                <a href="{{ Route::has('register') ? route('register') : '#' }}" class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition">{{ __('messages.register') ?? 'Daftar' }}</a>
            @endauth
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="w-full flex-grow px-8 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12 mt-auto w-full">
        <div class="w-full px-6 md:px-20 flex flex-col md:flex-row justify-start items-start gap-12 lg:gap-[130px]">
            
            <!-- Kolom 1: Brand & Sosial Media -->
            <div class="space-y-4 max-w-xs">
                <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="flex items-center gap-2 text-2xl font-bold text-indigo-600">
                    <img src="{{ asset('images/LOGO SKILLNEST.png') }}" alt="SkillNest Logo" class="h-8 w-auto" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=SN&background=4F46E5&color=fff';">
                    <span>SkillNest</span>
                </a>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ __('messages.footer_desc') ?? 'Tempat terbaik untuk belajar, berkolaborasi, dan mengembangkan potensi diri bersama para profesional berpengalaman.' }}
                </p>
                <div class="flex space-x-3 text-gray-400">
                    <a href="#" class="hover:text-indigo-600"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-indigo-600"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="hover:text-indigo-600"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="hover:text-indigo-600"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <!-- Kolom 2: Navigasi -->
            <div class="min-w-[140px]">
                <h4 class="font-bold text-sm text-gray-900 mb-4">{{ __('messages.nav_title') ?? 'Navigasi' }}</h4>
                <ul class="space-y-2 text-xs text-gray-600">
                    <li><a href="{{ Route::has('home') ? route('home') : url('/') }}" class="hover:text-indigo-600">{{ __('messages.nav_home') ?? 'Beranda' }}</a></li>
                    <li><a href="{{ Route::has('webinars.index') ? route('webinars.index') : '#' }}" class="hover:text-indigo-600">{{ __('messages.explore_btn') ?? 'Jelajahi Webinar' }}</a></li>
                    <li><a href="{{ Route::has('categories.index') ? route('categories.index') : (Route::has('categories') ? route('categories') : '#') }}" class="hover:text-indigo-600">{{ __('messages.nav_category') ?? 'Kategori' }}</a></li>
                    <li><a href="{{ Route::has('organizer.landing') ? route('organizer.landing') : '#' }}" class="hover:text-indigo-600">{{ __('messages.nav_organizer') ?? 'Untuk Penyelenggara' }}</a></li>
                    <li>
                        <a href="{{ Route::has('admin.login') ? route('admin.login') : url('/admin/login') }}" class="text-gray-400 hover:text-indigo-600 transition flex items-center gap-1.5 pt-1">
                            <i class="fas fa-user-shield text-[10px]"></i>
                            <span>{{ __('messages.admin_login') ?? 'Login Admin' }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3: Dukungan -->
            <div class="min-w-[140px]">
                <h4 class="font-bold text-sm text-gray-900 mb-4">{{ __('messages.support_title') ?? 'Dukungan' }}</h4>
                <ul class="space-y-2 text-xs text-gray-600">
                    <li><a href="#" class="hover:text-indigo-600">{{ __('messages.help_center') ?? 'Pusat Bantuan' }}</a></li>
                    <li><a href="#" class="hover:text-indigo-600">{{ __('messages.terms') ?? 'Syarat & Ketentuan' }}</a></li>
                    <li><a href="#" class="hover:text-indigo-600">{{ __('messages.privacy') ?? 'Kebijakan Privasi' }}</a></li>
                    <li><a href="#" class="hover:text-indigo-600">FAQ</a></li>
                </ul>
            </div>

            <!-- Kolom 4: Hubungi Kami -->
            <div class="min-w-[180px]">
                <h4 class="font-bold text-sm text-gray-900 mb-4">{{ __('messages.contact_title') ?? 'Hubungi Kami' }}</h4>
                <ul class="space-y-2 text-xs text-gray-600">
                    <li><i class="far fa-envelope mr-2 text-indigo-600"></i> skillnestweb@gmail.com</li>
                    <li><i class="fab fa-whatsapp mr-2 text-indigo-600"></i> +62 857 0400 3309</li>
                    <li><i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i> {{ __('messages.location') ?? 'Malang, Indonesia' }}</li>
                </ul>
            </div>

        </div>
    </footer>

</body>
</html>