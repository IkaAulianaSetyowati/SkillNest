@extends('layouts.app')

@section('content')
<main class="max-w-lg mx-auto px-4 py-12">
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
        <div>
            <h1 class="text-xl font-extrabold text-gray-900">Upload Bukti Pembayaran</h1>
            <p class="text-xs text-gray-500 mt-1">
                Metode: <span class="font-semibold text-gray-700">{{ strtoupper($registration->payment_method) }}</span>
            </p>
            <p class="text-lg font-bold text-indigo-600 mt-2">Rp {{ number_format($registration->amount, 0, ',', '.') }}</p>
        </div>

        @if($errors->any())
            <div class="p-3 bg-red-50 text-red-600 text-xs rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('registrations.proof.store', $registration->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-2">Foto/Screenshot Bukti Transfer</label>
                <input type="file" name="payment_proof" accept="image/*" required
                       class="w-full text-xs border border-gray-200 rounded-xl p-3">
            </div>

            <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-indigo-200 transition">
                Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</main>
@endsection