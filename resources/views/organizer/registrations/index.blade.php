@extends('organizer.layouts.app')

@section('content')
<div class="px-6 py-6 space-y-6">
    <h1 class="text-xl font-extrabold text-gray-900">Verifikasi Pendaftaran Peserta</h1>

    @if(session('success'))
        <div class="p-3 bg-green-50 text-green-700 text-xs rounded-xl">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-xs">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-4 py-3">Peserta</th>
                    <th class="px-4 py-3">Webinar</th>
                    <th class="px-4 py-3">Metode</th>
                    <th class="px-4 py-3">Bukti</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($registrations as $reg)
                    <tr>
                        <td class="px-4 py-3 font-semibold">{{ $reg->user->name }}</td>
                        <td class="px-4 py-3">{{ $reg->webinar->judul }}</td>
                        <td class="px-4 py-3">{{ strtoupper($reg->payment_method) }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ asset('storage/' . $reg->payment_proof) }}" target="_blank" class="text-indigo-600 font-semibold hover:underline">
                                Lihat Bukti
                            </a>
                        </td>
                        <td class="px-4 py-3 flex gap-2">
                            <form action="{{ route('organizer.registrations.approve', $reg->id) }}" method="POST">
                                @csrf
                                <button class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold">Setujui</button>
                            </form>
                            <form action="{{ route('organizer.registrations.reject', $reg->id) }}" method="POST">
                                @csrf
                                <button class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Tidak ada pendaftaran yang menunggu verifikasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection