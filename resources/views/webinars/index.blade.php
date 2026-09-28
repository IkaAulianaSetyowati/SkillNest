@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 flex gap-8 items-start">
    <!-- Sidebar Filter (Kiri) -->
    <aside class="w-64 flex-shrink-0 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6 sticky top-6">
        <div>
            <h3 class="font-bold text-sm text-gray-800 mb-3">{{ __('messages.category') }}</h3>
            <div class="space-y-2.5 text-xs text-gray-600">
                <label class="flex items-center gap-2 cursor-pointer hover:text-indigo-600">
                    <input type="checkbox" value="Semua" id="cat-all" class="category-checkbox rounded text-indigo-600 focus:ring-indigo-500" checked> 
                    <span>{{ __('messages.all_categories') }}</span>
                </label>

                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $cat)
                        <label class="flex items-center gap-2 cursor-pointer hover:text-indigo-600">
                            <input type="checkbox" value="{{ $cat }}" class="category-checkbox rounded text-indigo-600 focus:ring-indigo-500"> 
                            <span>{{ $cat }}</span>
                        </label>
                    @endforeach
                @endif
            </div>
        </div>

        <hr class="border-gray-100">

        <div>
            <h3 class="font-bold text-sm text-gray-800 mb-3">{{ __('messages.webinar_type') }}</h3>
            <div class="space-y-2.5 text-xs text-gray-600">
                <label class="flex items-center gap-2 cursor-pointer hover:text-indigo-600">
                    <input type="radio" name="type" value="Semua" checked class="text-indigo-600 focus:ring-indigo-500"> 
                    <span>{{ __('messages.all_types') }}</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-indigo-600">
                    <input type="radio" name="type" value="free" class="text-indigo-600 focus:ring-indigo-500"> 
                    <span>{{ __('messages.free') }}</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-indigo-600">
                    <input type="radio" name="type" value="paid" class="text-indigo-600 focus:ring-indigo-500"> 
                    <span>{{ __('messages.paid') }}</span>
                </label>
            </div>
        </div>

        <hr class="border-gray-100">

        <div>
            <h3 class="font-bold text-sm text-gray-800 mb-3">{{ __('messages.max_price_range') }}</h3>
            <input type="range" id="price-range" min="0" max="500000" step="5000" value="500000" class="w-full accent-indigo-600 cursor-pointer">
            <div class="flex justify-between text-[11px] text-gray-500 mt-2 font-medium">
                <span>Rp 0</span>
                <span id="price-display" class="font-bold text-indigo-600">Rp 500.000</span>
            </div>
        </div>

        <button id="btn-apply-filter" type="button" class="w-full py-2.5 bg-indigo-600 text-white font-bold text-xs rounded-xl hover:bg-indigo-700 active:scale-[0.98] transition shadow-sm">
            {{ __('messages.apply_filter') }}
        </button>
    </aside>

    <!-- List Webinar (Kanan) -->
    <main class="flex-1 min-w-0 space-y-4">
        <div class="flex justify-between items-center bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <div>
                <h1 class="font-bold text-lg text-gray-900">{{ __('messages.all_webinars') }}</h1>
                <p id="webinar-count" class="text-xs text-gray-400 mt-0.5">{{ __('messages.showing_all_webinars') ?? 'Menampilkan seluruh webinar' }}</p>
            </div>
            <select id="sort-filter" class="border border-gray-200 text-xs rounded-xl px-3 py-2 bg-white text-gray-700 outline-none focus:border-indigo-500 cursor-pointer shadow-sm">
                <option value="terbaru">{{ __('messages.sort_latest') }}</option>
                <option value="terendah">{{ __('messages.sort_lowest_price') }}</option>
                <option value="tertinggi">{{ __('messages.sort_highest_price') }}</option>
            </select>
        </div>

        <!-- Container Daftar Card -->
        <div id="webinar-container" class="space-y-4">
            @if(isset($webinars) && count($webinars) > 0)
                @foreach ($webinars as $item)
                    @php
                        $id = is_array($item) ? ($item['id'] ?? 1) : ($item->id ?? 1);
                        $title = is_array($item) ? ($item['title'] ?? '') : ($item->title ?? '');
                        $category = is_array($item) ? ($item['category'] ?? '') : ($item->category ?? '');
                        $speaker = is_array($item) ? ($item['speaker'] ?? '') : ($item->speaker ?? '');
                        $price = is_array($item) ? ($item['price'] ?? 0) : ($item->price ?? 0);
                        $type = is_array($item) ? ($item['type'] ?? 'free') : ($item->type ?? 'free');
                        $banner = is_array($item) ? ($item['banner'] ?? $item['image'] ?? null) : ($item->banner ?? ($item->image ?? null));
                        $date = is_array($item) ? ($item['date'] ?? null) : ($item->date ?? null);
                    @endphp

                    <div class="webinar-card bg-white p-4 rounded-2xl border border-gray-100 flex gap-5 items-center hover:shadow-md transition-all duration-200" 
                         data-category="{{ strtolower(trim($category)) }}" 
                         data-price="{{ (int) $price }}" 
                         data-type="{{ $type }}">
                        
                        <!-- Box Thumbnail Banner -->
                        <div class="w-48 h-28 flex-shrink-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-end p-3 text-white relative overflow-hidden shadow-inner">
                            @if (!empty($banner))
                                <img src="{{ Str::startsWith($banner, ['http://', 'https://']) ? $banner : asset('storage/' .$banner) }}" alt="" class="absolute inset-0 w-full h-full object-cover">
                            @endif
                            <span class="text-[10px] font-medium bg-black/30 backdrop-blur-md px-2.5 py-1 rounded-md border border-white/20 relative z-10 truncate">
                                {{ $category }}
                            </span>
                        </div>

                        <div class="flex-1 min-w-0 space-y-1.5">
                            <h3 class="font-bold text-sm text-gray-900 truncate" title="{{ $title }}">
                                {{ $title }}
                            </h3>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>{{ $speaker }}</span>
                            </p>
                            <p class="text-xs text-gray-400 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ $date ? \Carbon\Carbon::parse($date)->translatedFormat('d F Y • H.i') . ' WIB' : 'Jadwal segera' }}</span>
                            </p>
                        </div>

                        <div class="w-36 flex-shrink-0 text-right space-y-3 pl-4 border-l border-gray-100">
                            <p class="font-extrabold {{ $price == 0 ? 'text-emerald-600' : 'text-indigo-600' }} text-base">
                                {{ $price == 0 ? __('messages.free') : 'Rp ' . number_format($price, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('webinars.show', $id) }}" class="block w-full text-center py-2 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                {{ __('messages.view_details') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white p-12 rounded-2xl border border-gray-100 text-center text-gray-400 text-xs">
                    <p class="font-medium text-gray-600 text-sm">{{ __('messages.no_webinar_data') ?? 'Belum Ada Data Webinar' }}</p>
                    <p class="mt-1">{{ __('messages.add_db_data') ?? 'Silakan tambahkan data ke tabel database terlebih dahulu.' }}</p>
                </div>
            @endif
            
            <div id="no-data" class="hidden bg-white p-12 rounded-2xl border border-gray-100 text-center text-gray-400 text-xs">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <p class="font-medium text-gray-600 text-sm">{{ __('messages.no_webinar_found') ?? 'Tidak ada webinar yang ditemukan' }}</p>
                <p class="mt-1">{{ __('messages.adjust_filter') ?? 'Coba sesuaikan batas harga atau kategori pilihan Anda.' }}</p>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const priceRange = document.getElementById('price-range');
        const priceDisplay = document.getElementById('price-display');
        const btnApply = document.getElementById('btn-apply-filter');
        const catAll = document.getElementById('cat-all');
        const catCheckboxes = document.querySelectorAll('.category-checkbox');
        const webinarCards = Array.from(document.querySelectorAll('.webinar-card'));
        const container = document.getElementById('webinar-container');
        const noData = document.getElementById('no-data');
        const webinarCount = document.getElementById('webinar-count');
        const sortFilter = document.getElementById('sort-filter');

        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('search') ? urlParams.get('search').toLowerCase().trim() : '';

        if (priceRange) {
            priceRange.addEventListener('input', function() {
                if (priceDisplay) {
                    priceDisplay.textContent = 'Rp ' + parseInt(this.value, 10).toLocaleString('id-ID');
                }
            });
        }

        if (catAll) {
            catAll.addEventListener('change', function() {
                if (this.checked) {
                    catCheckboxes.forEach(cb => {
                        if (cb !== catAll) cb.checked = false;
                    });
                }
            });

            catCheckboxes.forEach(cb => {
                if (cb !== catAll) {
                    cb.addEventListener('change', function() {
                        const anyChecked = Array.from(catCheckboxes).some(c => c !== catAll && c.checked);
                        if (anyChecked) {
                            catAll.checked = false;
                        } else {
                            catAll.checked = true;
                        }
                    });
                }
            });
        }

        function applyFilters() {
            const maxPrice = priceRange ? parseInt(priceRange.value, 10) : 500000;
            const selectedTypeObj = document.querySelector('input[name="type"]:checked');
            const selectedType = selectedTypeObj ? selectedTypeObj.value : 'Semua';
            
            let selectedCategories = [];
            catCheckboxes.forEach(cb => {
                if (cb.checked && cb !== catAll) {
                    selectedCategories.push(cb.value.toLowerCase().trim());
                }
            });

            let visibleCount = 0;

            webinarCards.forEach(card => {
                const cardTitle = card.querySelector('h3') ? card.querySelector('h3').textContent.toLowerCase().trim() : '';
                const cardCategory = card.getAttribute('data-category') ? card.getAttribute('data-category').toLowerCase().trim() : '';
                const cardPrice = card.getAttribute('data-price') ? parseInt(card.getAttribute('data-price'), 10) : 0;

                const matchSearch = (searchQuery === '') || cardTitle.includes(searchQuery) || cardCategory.includes(searchQuery);
                const matchCategory = catAll.checked || selectedCategories.length === 0 || selectedCategories.includes(cardCategory);

                let matchTypeAndPrice = false;

                if (selectedType === 'free') {
                    matchTypeAndPrice = (cardPrice === 0);
                } else if (selectedType === 'paid') {
                    matchTypeAndPrice = (cardPrice > 0) && (cardPrice <= maxPrice);
                } else { 
                    matchTypeAndPrice = (cardPrice <= maxPrice);
                }

                if (matchSearch && matchCategory && matchTypeAndPrice) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (webinarCount) {
                webinarCount.textContent = searchQuery !== '' 
                    ? `Menampilkan ${visibleCount} hasil untuk "${searchQuery}"` 
                    : `Menampilkan ${visibleCount} webinar`;
            }

            if (noData) {
                if (visibleCount === 0) {
                    noData.classList.remove('hidden');
                } else {
                    noData.classList.add('hidden');
                }
            }
        }

        if (sortFilter) {
            sortFilter.addEventListener('change', function() {
                const sortValue = this.value;
                webinarCards.sort((a, b) => {
                    const priceA = parseInt(a.getAttribute('data-price'), 10);
                    const priceB = parseInt(b.getAttribute('data-price'), 10);

                    if (sortValue === 'terendah') return priceA - priceB;
                    if (sortValue === 'tertinggi') return priceB - priceA;
                    return 0;
                });

                webinarCards.forEach(card => container.appendChild(card));
            });
        }

        if (btnApply) {
            btnApply.addEventListener('click', applyFilters);
        }

        applyFilters();
    });
</script>
@endsection