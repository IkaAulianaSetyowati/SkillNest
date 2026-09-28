@extends('layouts.app')

@section('content')
<main class="max-w-lg mx-auto px-4 py-12">
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
        <div>
            <h1 class="text-xl font-extrabold text-gray-900">Pilih Metode Pembayaran</h1>
            <p class="text-xs text-gray-500 mt-1">Webinar: {{ $registration->webinar->judul }}</p>
            <p class="text-lg font-bold text-indigo-600 mt-2">Rp {{ number_format($registration->amount, 0, ',', '.') }}</p>
        </div>

        <form action="{{ route('registrations.payment.store', $registration->id) }}" method="POST" class="space-y-4">
            @csrf

            @foreach(['dana' => 'DANA', 'ovo' => 'OVO', 'gopay' => 'GoPay', 'bank_transfer' => 'Transfer Bank'] as $value => $label)
                <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-indigo-400 transition">
                    <input type="radio" name="payment_method" value="{{ $value }}" required class="text-indigo-600">
                    <span class="font-semibold text-sm text-gray-800">{{ $label }}</span>
                </label>
            @endforeach

            <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-indigo-200 transition">
                Lanjutkan
            </button>
        </form>
    </div>
</main>
@endsection