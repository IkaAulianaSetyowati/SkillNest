@extends('layouts.app')

@section('content')
<div class="px-[2cm] py-6 space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Riwayat Webinar</h1>
            <p class="text-xs text-gray-500 mt-0.5">Daftar webinar yang telah Anda ikuti dan selesaikan.</p>
        </div>
        <div class="flex items-center gap-2">
            <select class="border border-gray-200 text-xs rounded-xl px-3 py-2 bg-white text-gray-700 font-medium shadow-sm">
                <option>Semua Status</option>
                <option>Selesai</option>
                <option>Sedang Berlangsung</option>
            </select>
        </div>
    </div>

    <!-- List Riwayat -->
    <div class="space-y-4">
        @php
            $historyItems = [
                [
                    'title' => 'Leadership Masterclass: Menjadi Pemimpin Efektif di Era Digital',
                    'speaker' => 'Hendro Wijaya',
                    'category' => 'Pendidikan & Karir',
                    'date' => '18 July 2026 • 19.00 WIB',
                    'status' => 'Selesai',
                    'certificate' => true,
                    'banner' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=400&q=80'
                ]
            ];
        @endphp

        @forelse($historyItems as $item)
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm hover:shadow-md transition">
                <div class="flex items-start gap-4">
                    <img src="{{ $item['banner'] }}" class="w-24 h-20 rounded-xl object-cover flex-shrink-0" alt="Banner">
                    <div class="space-y-1.5">
                        <span class="text-[10px] bg-indigo-50 text-indigo-600 px-2.5 py-0.5 rounded-full font-semibold">
                            {{ $item['category'] }}
                        </span>
                        <h3 class="font-bold text-gray-900 text-sm md:text-base leading-snug">{{ $item['title'] }}</h3>
                        <p class="text-xs text-gray-500"><i class="far fa-user mr-1 text-indigo-500"></i> {{ $item['speaker'] }} &bull; <i class="far fa-calendar ml-2 mr-1 text-indigo-500"></i> {{ $item['date'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full md:w-auto justify-end border-t md:border-t-0 pt-3 md:pt-0">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $item['status'] == 'Selesai' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                        {{ $item['status'] }}
                    </span>
                    @if($item['certificate'])
                        <a href="#" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <i class="fas fa-download mr-1"></i> Sertifikat
                        </a>
                    @else
                        <a href="#" class="px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-bold rounded-xl transition">
                            Lihat Detail
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm space-y-3">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto text-xl">
                    <i class="fas fa-history"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Belum Ada Riwayat</h3>
                <p class="text-xs text-gray-400">Anda belum mengikuti webinar apapun.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection