@extends('layouts.app')

@section('content')
<main class="max-w-lg mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden border-l-8 border-l-indigo-600">
        <div class="p-8 space-y-5">
            <div class="flex justify-between items-center">
                <span class="text-xs font-mono font-bold bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full">
                    {{ $registration->registration_code }}
                </span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                    E-Tiket Aktif
                </span>
            </div>

            <h1 class="text-lg font-bold text-gray-900">{{ $registration->webinar->judul }}</h1>

            <div class="grid grid-cols-2 gap-4 pt-3 border-t border-gray-100 text-xs text-gray-600">
                <div>
                    <span class="text-gray-400 block text-[10px]">Tanggal & Waktu</span>
                    <p class="font-semibold mt-0.5">
                        <i class="far fa-calendar mr-1 text-indigo-500"></i>
                        {{ \Carbon\Carbon::parse($registration->webinar->tanggal)->isoFormat('D MMMM YYYY') }}
                    </p>
                    <p class="font-semibold">
                        <i class="far fa-clock mr-1 text-indigo-500"></i>
                        {{ \Carbon\Carbon::parse($registration->webinar->waktu)->format('H:i') }} WIB
                    </p>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px]">Narasumber</span>
                    <p class="font-semibold mt-0.5"><i class="far fa-user mr-1 text-indigo-500"></i> {{ $registration->webinar->speaker }}</p>
                </div>
            </div>

            @if(!empty($registration->webinar->group_link))
                <div class="bg-indigo-50/60 border border-indigo-100 p-3.5 rounded-2xl flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-sm">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-indigo-500 font-semibold uppercase">Informasi Panitia</p>
                            <p class="text-xs font-bold text-gray-900">Gabung Grup Webinar</p>
                        </div>
                    </div>
                    <a href="{{ $registration->webinar->group_link }}" target="_blank"
                       class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5">
                        <i class="fas fa-external-link-alt text-[10px]"></i> Gabung
                    </a>
                </div>
            @else
                <div class="bg-gray-50 border border-gray-100 p-3.5 rounded-2xl text-xs text-gray-500">
                    Link grup akan segera ditambahkan oleh penyelenggara.
                </div>
            @endif
        </div>

        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100">
            <a href="{{ route('tickets.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                <i class="fas fa-arrow-left mr-1"></i> Lihat Semua Tiket Saya
            </a>
        </div>
    </div>
</main>
@endsection