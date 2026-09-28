@extends('layouts.app')

@section('content')
<div class="px-[2cm] py-6 space-y-8">
    <div>
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Tiket Saya</h1>
        <p class="text-xs text-gray-500 mt-0.5">Gunakan tiket ini untuk mengakses sesi webinar dan bergabung ke grup informasi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($registrations as $reg)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition overflow-hidden flex flex-col justify-between border-l-8 border-l-indigo-600">
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-mono font-bold bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full">
                            {{ $reg->registration_code }}
                        </span>
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                            Terdaftar
                        </span>
                    </div>

                    <h3 class="font-bold text-gray-900 text-base leading-snug">{{ $reg->webinar->judul }}</h3>

                    <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-100 text-xs text-gray-600">
                        <div>
                            <span class="text-gray-400 block text-[10px]">Waktu Pelaksanaan</span>
                            <p class="font-semibold mt-0.5"><i class="far fa-calendar mr-1 text-indigo-500"></i> {{ \Carbon\Carbon::parse($reg->webinar->tanggal)->isoFormat('D MMM YYYY') }}</p>
                            <p class="font-semibold"><i class="far fa-clock mr-1 text-indigo-500"></i> {{ \Carbon\Carbon::parse($reg->webinar->waktu)->format('H:i') }} WIB</p>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px]">Narasumber</span>
                            <p class="font-semibold mt-0.5"><i class="far fa-user mr-1 text-indigo-500"></i> {{ $reg->webinar->speaker }}</p>
                        </div>
                    </div>

                    <!-- BAGIAN QR CODE & KETERANGAN GABUNG GRUP -->
            <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl flex flex-col items-center text-center space-y-2">
                              <!-- Ubah path asset di bawah ini -->
                <img src="{{ asset('images/qr.jpeg') }}" alt="QR Grup WhatsApp" class="w-32 h-32 object-contain rounded-lg bg-white p-1 border border-gray-200 shadow-sm">
                <p class="text-xs font-bold text-gray-800">
                     📱 Scan QR untuk gabung ke grup
                </p>
            </div>

                    @if(!empty($reg->webinar->group_link))
                        <div class="bg-indigo-50/60 border border-indigo-100 p-3.5 rounded-2xl flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center flex-shrink-0 text-sm shadow-sm">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-indigo-500 font-semibold uppercase tracking-wider">Informasi Panitia</p>
                                    <p class="text-xs font-bold text-gray-900">Gabung Grup Webinar</p>
                                </div>
                            </div>
                            <a href="{{ $reg->webinar->group_link }}" target="_blank" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center gap-1.5 flex-shrink-0">
                                <i class="fas fa-external-link-alt text-[10px]"></i> Gabung Grup
                            </a>
                        </div>
                    @endif
                </div>

                <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-[10px] text-gray-400 font-medium">Status: Tiket Valid & Aktif</span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm space-y-3">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto text-xl">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Tidak Ada Tiket Aktif</h3>
                <p class="text-xs text-gray-400">Anda belum memesan tiket webinar.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection