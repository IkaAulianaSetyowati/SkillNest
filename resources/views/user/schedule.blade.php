@extends('layouts.app')

@section('content')
<div class="px-[2cm] py-6 space-y-8">
    <div>
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Jadwal Webinar Saya</h1>
        <p class="text-xs text-gray-500 mt-0.5">Agenda kegiatan webinar mendatang yang sudah Anda daftarkan.</p>
    </div>

    <div class="space-y-4">
        @forelse($registrations as $reg)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:shadow-md transition">
                <div class="flex items-start md:items-center gap-4">
                    <!-- Kotak Tanggal / Bulan -->
                    <div class="bg-indigo-50 text-indigo-600 rounded-2xl p-3 text-center min-w-[70px] flex-shrink-0">
                        <span class="text-[10px] font-bold uppercase tracking-wider block">
                            {{ \Carbon\Carbon::parse($reg->webinar->tanggal)->isoFormat('MMM') }}
                        </span>
                        <span class="text-xl font-black block">
                            {{ \Carbon\Carbon::parse($reg->webinar->tanggal)->format('d') }}
                        </span>
                    </div>

                    <!-- Informasi Webinar -->
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 text-xs text-indigo-600 font-semibold">
                            <i class="far fa-clock"></i> 
                            <span>{{ \Carbon\Carbon::parse($reg->webinar->waktu)->format('H:i') }} WIB</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-base leading-snug">
                            {{ $reg->webinar->judul }}
                        </h3>
                        <p class="text-xs text-gray-500">
                            <i class="far fa-user mr-1 text-gray-400"></i> Pembicara: {{ $reg->webinar->speaker }}
                        </p>
                    </div>
                </div>

                <!-- Tombol Aksi Masuk Ruangan -->
                <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                    @if(!empty($reg->webinar->meeting_link))
                        <a href="{{ $reg->webinar->meeting_link }}" target="_blank" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center gap-2 w-full md:w-auto justify-center">
                            <i class="fas fa-video text-xs"></i> Masuk Ruangan
                        </a>
                    @else
                        <span class="px-3 py-2 bg-gray-100 text-gray-400 text-xs font-semibold rounded-xl">
                            Link Belum Tersedia
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm space-y-3">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto text-xl">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Tidak Ada Jadwal Aktif</h3>
                <p class="text-xs text-gray-400">Anda belum memiliki agenda webinar terdaftar.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection