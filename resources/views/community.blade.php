@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- KOLOM KIRI: Navigation Sidebar -->
        <div class="lg:col-span-3 space-y-4 sticky top-20">
            <!-- Navigation Menu Card -->
            <div class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm space-y-1">
                <button onclick="switchTab('eksplor')" id="tab-btn-eksplor" 
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition duration-200 bg-indigo-50 text-indigo-600">
                    <i class="fas fa-home text-base"></i> Eksplor Komunitas
                </button>
                <button onclick="switchTab('grup')" id="tab-btn-grup" 
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-xs text-gray-600 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-user-friends text-base"></i> Grup Saya
                    <span class="ml-auto bg-indigo-100 text-indigo-600 text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $myGroupsCount ?? 2 }}</span>
                </button>
                <button onclick="switchTab('notifikasi')" id="tab-btn-notifikasi" 
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-xs text-gray-600 hover:bg-gray-50 transition duration-200">
                    <i class="far fa-bell text-base"></i> Notifikasi
                    @if(($unreadNotificationsCount ?? 3) > 0)
                        <span class="ml-auto bg-red-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $unreadNotificationsCount ?? 3 }}</span>
                    @endif
                </button>
                <button onclick="switchTab('tersimpan')" id="tab-btn-tersimpan" 
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-xs text-gray-600 hover:bg-gray-50 transition duration-200">
                    <i class="far fa-bookmark text-base"></i> Tersimpan
                </button>
            </div>

            <!-- Widget Grup Terpopuler -->
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-xs font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-users text-indigo-600"></i> Grup Terpopuler
                    </h3>
                    <a href="{{ Route::has('groups.index') ? route('groups.index') : '#' }}" class="text-[11px] font-semibold text-indigo-600 hover:underline">Lihat Semua</a>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition">
                        <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                            &lt;/&gt;
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-800 truncate">Web Developer ID</p>
                            <p class="text-[10px] text-gray-400">12.4k Anggota • Publik</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition">
                        <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-800 truncate">Laravel Private Circle</p>
                            <p class="text-[10px] text-gray-400">120 Anggota • Undangan</p>
                        </div>
                    </div>
                </div>

                <button onclick="openModal('modalGrup')" class="w-full mt-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold text-xs rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Buat Grup Baru
                </button>
            </div>

            <!-- Tombol Buat Postingan Utama -->
            <button onclick="openModal('modalPostingan')" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-xs rounded-2xl shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2">
                <i class="fas fa-edit"></i> Buat Postingan
            </button>
        </div>


        <!-- KOLOM TENGAH: Konten Dinamis -->
        <div class="lg:col-span-6 space-y-4">

            <!-- TAB 1: EKSPLOR KOMUNITAS -->
            <div id="tab-content-eksplor" class="tab-content space-y-4">
                
                <!-- Sub-Tab Switcher: Untuk Anda vs Mengikuti -->
                <div class="bg-white rounded-2xl p-1 border border-gray-100 shadow-sm grid grid-cols-2 text-center text-xs font-bold">
                    <button onclick="switchSubTab('untuk-anda')" id="subtab-btn-untuk-anda" 
                        class="subtab-btn py-2.5 rounded-xl bg-indigo-50 text-indigo-600 transition">
                        Untuk Anda
                    </button>
                    <button onclick="switchSubTab('mengikuti')" id="subtab-btn-mengikuti" 
                        class="subtab-btn py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 transition">
                        Mengikuti
                    </button>
                </div>

                <!-- Input Card Cepat -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <input type="text" onclick="openModal('modalPostingan')" readonly placeholder="Apa yang ingin kamu bagikan ke komunitas?" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs cursor-pointer hover:bg-slate-100 transition">
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-gray-400 text-sm">
                        <div class="flex gap-4 pl-2">
                            <button type="button" onclick="openModal('modalPostingan')" class="hover:text-indigo-600"><i class="far fa-image"></i></button>
                            <button type="button" onclick="openModal('modalPostingan')" class="hover:text-indigo-600"><i class="fas fa-poll-h"></i></button>
                            <button type="button" onclick="openModal('modalPostingan')" class="hover:text-indigo-600"><i class="far fa-smile"></i></button>
                            <button type="button" onclick="openModal('modalPostingan')" class="hover:text-indigo-600"><i class="fas fa-code"></i></button>
                        </div>
                        <button type="button" onclick="openModal('modalPostingan')" class="px-5 py-2 bg-indigo-600 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">Posting</button>
                    </div>
                </div>

                <!-- KONTEN SUB-TAB 1: UNTUK ANDA -->
                <div id="subtab-content-untuk-anda" class="subtab-content space-y-4">
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">AD</div>
                                <div>
                                    <p class="text-xs font-bold text-gray-800">Aris Dev <span class="text-gray-400 font-normal">@arisdev • 10m</span></p>
                                    <span class="bg-indigo-50 text-indigo-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Web Development</span>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600 text-xs"><i class="fas fa-ellipsis-h"></i></button>
                        </div>
                        <p class="text-xs text-gray-700 leading-relaxed">Halo teman-teman di grup privat! Ini link diskusi khusus buat yang ikut sesi mentoring semalam ya.</p>
                        <div class="flex items-center gap-6 pt-3 border-t border-slate-100 text-gray-400 text-xs font-semibold">
                            <button class="hover:text-indigo-600 flex items-center gap-1.5"><i class="far fa-comment"></i> 5</button>
                            <button class="hover:text-red-500 flex items-center gap-1.5"><i class="far fa-heart"></i> 18</button>
                            <button class="hover:text-indigo-600 flex items-center gap-1.5 ml-auto"><i class="far fa-bookmark"></i></button>
                        </div>
                    </div>
                </div>

                <!-- KONTEN SUB-TAB 2: MENGIKUTI -->
                <div id="subtab-content-mengikuti" class="subtab-content space-y-4 hidden">
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">BS</div>
                                <div>
                                    <p class="text-xs font-bold text-gray-800">Budi Santoso <span class="text-gray-400 font-normal">@budis • 25m</span></p>
                                    <span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Frontend</span>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600 text-xs"><i class="fas fa-ellipsis-h"></i></button>
                        </div>
                        <p class="text-xs text-gray-700 leading-relaxed">Baru aja rilis komponen Tailwind UI baru untuk dashboard Laravel. Ada yang mau nyobain duluan?</p>
                        <div class="flex items-center gap-6 pt-3 border-t border-slate-100 text-gray-400 text-xs font-semibold">
                            <button class="hover:text-indigo-600 flex items-center gap-1.5"><i class="far fa-comment"></i> 12</button>
                            <button class="hover:text-red-500 flex items-center gap-1.5"><i class="far fa-heart"></i> 34</button>
                            <button class="hover:text-indigo-600 flex items-center gap-1.5 ml-auto"><i class="far fa-bookmark"></i></button>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-xs">SR</div>
                                <div>
                                    <p class="text-xs font-bold text-gray-800">Siti Rahma <span class="text-gray-400 font-normal">@siti_uiux • 1j</span></p>
                                    <span class="bg-purple-50 text-purple-600 text-[10px] font-bold px-2 py-0.5 rounded-full">UI/UX Design</span>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600 text-xs"><i class="fas fa-ellipsis-h"></i></button>
                        </div>
                        <p class="text-xs text-gray-700 leading-relaxed">Tips memilih palet warna yang accessible untuk pengguna dark mode & light mode di web aplikasi kamu 🎨</p>
                        <div class="flex items-center gap-6 pt-3 border-t border-slate-100 text-gray-400 text-xs font-semibold">
                            <button class="hover:text-indigo-600 flex items-center gap-1.5"><i class="far fa-comment"></i> 8</button>
                            <button class="hover:text-red-500 flex items-center gap-1.5"><i class="far fa-heart"></i> 42</button>
                            <button class="hover:text-indigo-600 flex items-center gap-1.5 ml-auto"><i class="far fa-bookmark"></i></button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TAB 2: GRUP SAYA -->
            <div id="tab-content-grup" class="tab-content space-y-4 hidden">
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-extrabold text-gray-900">Grup Yang Anda Ikuti</h2>
                        <p class="text-[11px] text-gray-400">Kelola dan jelajahi grup komunitas pilihanmu</p>
                    </div>
                    <button onclick="openModal('modalGrup')" class="px-3.5 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition">
                        + Buat Grup
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-extrabold text-sm">&lt;/&gt;</div>
                                <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2.5 py-1 rounded-full">Anggota</span>
                            </div>
                            <h3 class="text-xs font-bold text-gray-800">Web Developer ID</h3>
                            <p class="text-[11px] text-gray-400 mt-1 line-clamp-2">Komunitas belajar programming & sharing seputar dunia web dev indonesia.</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-gray-400 font-medium">
                            <span><i class="fas fa-users text-indigo-500 mr-1"></i> 12.4k Anggota</span>
                            <button class="text-indigo-600 font-bold hover:underline">Buka Grup &rarr;</button>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-extrabold text-sm"><i class="fas fa-shield-alt"></i></div>
                                <span class="bg-purple-50 text-purple-600 text-[10px] font-bold px-2.5 py-1 rounded-full">Admin</span>
                            </div>
                            <h3 class="text-xs font-bold text-gray-800">Laravel Private Circle</h3>
                            <p class="text-[11px] text-gray-400 mt-1 line-clamp-2">Grup eksklusif untuk diskusi seputar instruktur dan webinar Laravel SkillNest.</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-gray-400 font-medium">
                            <span><i class="fas fa-users text-indigo-500 mr-1"></i> 120 Anggota</span>
                            <button class="text-indigo-600 font-bold hover:underline">Kelola &rarr;</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: NOTIFIKASI -->
            <div id="tab-content-notifikasi" class="tab-content space-y-4 hidden">
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-extrabold text-gray-900">Notifikasi</h2>
                        <p class="text-[11px] text-gray-400">Pemberitahuan aktivitas komunitasmu</p>
                    </div>
                    <button class="text-[11px] font-bold text-indigo-600 hover:underline">Tandai Semua Dibaca</button>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm divide-y divide-gray-100 overflow-hidden">
                    <div class="p-4 bg-indigo-50/40 flex items-start gap-3 hover:bg-indigo-50/70 transition">
                        <div class="w-8 h-8 rounded-full bg-red-100 text-red-500 flex items-center justify-center text-xs flex-shrink-0 mt-0.5"><i class="fas fa-heart"></i></div>
                        <div class="flex-1 text-xs">
                            <p class="text-gray-800"><span class="font-bold">Budi Santoso</span> menyukai postingan Anda di grup <span class="font-semibold text-indigo-600">Web Developer ID</span>.</p>
                            <span class="text-[10px] text-gray-400 mt-1 block">5 menit yang lalu</span>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-indigo-600 flex-shrink-0"></div>
                    </div>

                    <div class="p-4 bg-indigo-50/40 flex items-start gap-3 hover:bg-indigo-50/70 transition">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs flex-shrink-0 mt-0.5"><i class="fas fa-comment-alt"></i></div>
                        <div class="flex-1 text-xs">
                            <p class="text-gray-800"><span class="font-bold">Siti Rahma</span> mengomentari postingan Anda: <i>"Boleh share link slide presentasinya mas?"</i></p>
                            <span class="text-[10px] text-gray-400 mt-1 block">1 jam yang lalu</span>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-indigo-600 flex-shrink-0"></div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: TERSIMPAN -->
            <div id="tab-content-tersimpan" class="tab-content space-y-4 hidden">
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <h2 class="text-sm font-extrabold text-gray-900">Postingan Tersimpan</h2>
                    <p class="text-[11px] text-gray-400">Daftar postingan & materi yang kamu simpan untuk dibaca nanti</p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-xs">SR</div>
                            <div>
                                <p class="text-xs font-bold text-gray-800">Siti Rahma <span class="text-gray-400 font-normal">@siti_uiux • 2 hari lalu</span></p>
                                <span class="bg-purple-50 text-purple-600 text-[10px] font-bold px-2 py-0.5 rounded-full">UI/UX Design</span>
                            </div>
                        </div>
                        <button class="text-indigo-600 hover:text-indigo-800 text-xs font-bold flex items-center gap-1">
                            <i class="fas fa-bookmark"></i> Tersimpan
                        </button>
                    </div>
                    <p class="text-xs text-gray-700 leading-relaxed">Berikut rekap 5 checklist utama sebelum melakukan design hand-over ke front-end developer:</p>
                    <div class="bg-slate-50 p-3 rounded-xl text-xs text-gray-600 space-y-1 font-mono">
                        <p>1. Organize Layers & Naming Component</p>
                        <p>2. Color Palette Token Check</p>
                        <p>3. Responsive Breakpoint Layouts</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN: Search & Topik Populer -->
        <div class="lg:col-span-3 space-y-4">
            <div class="relative">
                <input type="text" placeholder="Cari topik, grup, atau orang..." 
                    class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-100 rounded-2xl text-xs shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 text-xs"></i>
            </div>

            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-3">
                <h3 class="text-xs font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-fire text-orange-500"></i> Topik Populer
                </h3>
                <div class="space-y-2.5 text-xs">
                    <div class="hover:bg-slate-50 p-2 rounded-xl transition cursor-pointer">
                        <p class="text-[10px] text-gray-400">Teknologi • Trending</p>
                        <p class="font-bold text-gray-800">#Laravel11</p>
                        <p class="text-[10px] text-gray-400">1.2k Posting</p>
                    </div>
                </div>
            </div>

            <div class="text-[11px] text-gray-400 px-2 space-y-1">
                <p>Ketentuan • Privasi • Bantuan • Tentang</p>
                <p>&copy; {{ date('Y') }} SkillNest, Inc.</p>
            </div>
        </div>

    </div>
</div>

<!-- MODAL BUAT POSTINGAN -->
<div id="modalPostingan" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white w-full max-w-lg rounded-3xl p-6 shadow-2xl relative space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <h3 class="text-sm font-extrabold text-gray-900">Buat Postingan Komunitas</h3>
            <button type="button" onclick="closeModal('modalPostingan')" class="text-gray-400 hover:text-gray-600 text-sm"><i class="fas fa-times"></i></button>
        </div>

        <form action="{{ Route::has('posts.store') ? route('posts.store') : '#' }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Posting Ke:</label>
                <select name="group_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="publik">🌐 Publik (Semua Orang)</option>
                    <option value="web-dev">Web Developer ID (Grup)</option>
                    <option value="laravel">Laravel Private Circle (Grup)</option>
                </select>
            </div>

            <div>
                <textarea name="content" rows="4" placeholder="Apa yang ingin kamu bagikan atau tanyakan?" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition resize-none" required></textarea>
            </div>

            <div class="flex items-center justify-between pt-2">
                <div class="flex gap-3 text-gray-400 text-sm">
                    <button type="button" class="hover:text-indigo-600"><i class="far fa-image"></i></button>
                    <button type="button" class="hover:text-indigo-600"><i class="fas fa-link"></i></button>
                    <button type="button" class="hover:text-indigo-600"><i class="fas fa-hashtag"></i></button>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-100 transition">
                    Kirim Postingan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL BUAT GRUP BARU -->
<div id="modalGrup" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white w-full max-w-lg rounded-3xl p-6 shadow-2xl relative space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <h3 class="text-sm font-extrabold text-gray-900">Buat Grup Baru</h3>
            <button type="button" onclick="closeModal('modalGrup')" class="text-gray-400 hover:text-gray-600 text-sm"><i class="fas fa-times"></i></button>
        </div>

        <form action="{{ Route::has('groups.store') ? route('groups.store') : '#' }}" method="POST" class="space-y-3.5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Grup</label>
                <input type="text" name="name" placeholder="Contoh: Flutter Dev Indonesia" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Kategori / Topik</label>
                <input type="text" name="category" placeholder="Contoh: Mobile App, Design, AI" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Privasi Grup</label>
                <select name="privacy" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="publik">Publik (Siapa saja bisa bergabung)</option>
                    <option value="privat">Privat (Hanya via undangan/persetujuan admin)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea name="description" rows="3" placeholder="Jelaskan tujuan atau topik diskusi grup ini..." 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3">
                <button type="button" onclick="closeModal('modalGrup')" class="px-4 py-2 text-xs font-bold text-gray-500 hover:bg-slate-50 rounded-xl">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-100 transition">
                    Buat Grup
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-indigo-50', 'text-indigo-600', 'font-bold');
            btn.classList.add('text-gray-600', 'font-semibold');
        });
        document.getElementById('tab-content-' + tabName).classList.remove('hidden');
        const activeBtn = document.getElementById('tab-btn-' + tabName);
        activeBtn.classList.add('bg-indigo-50', 'text-indigo-600', 'font-bold');
        activeBtn.classList.remove('text-gray-600', 'font-semibold');
    }

    function switchSubTab(subTabName) {
        document.querySelectorAll('.subtab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.subtab-btn').forEach(btn => {
            btn.classList.remove('bg-indigo-50', 'text-indigo-600');
            btn.classList.add('text-gray-500');
        });
        document.getElementById('subtab-content-' + subTabName).classList.remove('hidden');
        const activeSubBtn = document.getElementById('subtab-btn-' + subTabName);
        activeSubBtn.classList.add('bg-indigo-50', 'text-indigo-600');
        activeSubBtn.classList.remove('text-gray-500');
    }

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection