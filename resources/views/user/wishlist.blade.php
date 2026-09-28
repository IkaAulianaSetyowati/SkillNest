@extends('layouts.app')

@section('content')
<div class="px-[2cm] py-6 space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Wishlist Saya</h1>
        <p class="text-xs text-gray-500 mt-0.5">Daftar webinar yang Anda simpan untuk dipelajari nanti.</p>
    </div>

    <!-- Grid Wishlist -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $wishlists = [
                [
                    'title' => 'Public Speaking Mastery: Bicara Percaya Diri di Depan Umum',
                    'speaker' => 'Budi Santoso',
                    'category' => 'Pengembangan Diri',
                    'date' => '02 Nov 2026',
                    'price' => 75000,
                    'banner' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=500&q=80'
                ],
                [
                    'title' => 'Creative Content Creation & Storytelling Strategy',
                    'speaker' => 'Siti Rahma',
                    'category' => 'Lainnya',
                    'date' => '25 Nov 2026',
                    'price' => 0,
                    'banner' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=500&q=80'
                ]
            ];
        @endphp

        @forelse($wishlists as $item)
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition flex flex-col justify-between group">
                <div>
                    <div class="relative h-44 bg-indigo-900">
                        <img src="{{ $item['banner'] }}" class="w-full h-full object-cover opacity-80" alt="Banner">
                        <span class="absolute top-3 left-3 bg-indigo-600/90 text-white text-[10px] font-semibold px-2.5 py-1 rounded-md">
                            {{ $item['category'] }}
                        </span>
                        <button class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-rose-500 flex items-center justify-center transition shadow-md">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                    <div class="p-4 space-y-2">
                        <span class="text-xs text-gray-400"><i class="far fa-calendar text-indigo-500 mr-1"></i> {{ $item['date'] }}</span>
                        <h3 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-indigo-600 transition line-clamp-2">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-xs text-gray-500"><i class="far fa-user text-indigo-500 mr-1"></i> {{ $item['speaker'] }}</p>
                    </div>
                </div>

                <div class="p-4 pt-0 border-t border-gray-50 mt-2 flex items-center justify-between">
                    <p class="font-bold {{ $item['price'] == 0 ? 'text-emerald-600' : 'text-indigo-600' }} text-sm">
                        {{ $item['price'] == 0 ? 'Gratis' : 'Rp ' . number_format($item['price'], 0, ',', '.') }}
                    </p>
                    <a href="#" class="px-4 py-2 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-xl hover:bg-indigo-600 hover:text-white transition">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm space-y-3">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto text-xl">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Wishlist Kosong</h3>
                <p class="text-xs text-gray-400">Belum ada webinar yang Anda simpan ke wishlist.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection