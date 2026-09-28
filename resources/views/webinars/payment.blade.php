@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8 my-8" x-data="{ selectedMethod: '' }">
    <h2 class="text-xl font-bold text-gray-800 mb-2">Selesaikan Pembayaran</h2>
    <p class="text-xs text-gray-500 mb-6">Pilih metode pembayaran di bawah ini dan lakukan transfer sesuai nominal tertera.</p>

    <!-- Total Tagihan -->
    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 mb-6 flex items-center justify-between">
        <span class="text-xs font-semibold text-indigo-900">Total yang harus dibayar:</span>
        <span class="text-base font-bold text-indigo-600">Rp {{ number_format($webinar->price, 0, ',', '.') }}</span>
    </div>

    <form action="{{ route('webinars.payment.submit', $webinar->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Pilihan Metode Pembayaran -->
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-3">Pilih Metode Pembayaran</label>
            <div class="grid grid-cols-2 gap-3">
                <!-- DANA -->
                <label @click="selectedMethod = 'dana'" :class="selectedMethod == 'dana' ? 'border-indigo-600 bg-indigo-50/50' : 'border-gray-200'" class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:border-indigo-600 transition">
                    <input type="radio" name="payment_method" value="dana" required class="text-indigo-600 focus:ring-indigo-500">
                    <span class="text-xs font-semibold text-gray-800">DANA</span>
                </label>
                <!-- OVO -->
                <label @click="selectedMethod = 'ovo'" :class="selectedMethod == 'ovo' ? 'border-indigo-600 bg-indigo-50/50' : 'border-gray-200'" class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:border-indigo-600 transition">
                    <input type="radio" name="payment_method" value="ovo" required class="text-indigo-600 focus:ring-indigo-500">
                    <span class="text-xs font-semibold text-gray-800">OVO</span>
                </label>
                <!-- GOPAY -->
                <label @click="selectedMethod = 'gopay'" :class="selectedMethod == 'gopay' ? 'border-indigo-600 bg-indigo-50/50' : 'border-gray-200'" class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:border-indigo-600 transition">
                    <input type="radio" name="payment_method" value="gopay" required class="text-indigo-600 focus:ring-indigo-500">
                    <span class="text-xs font-semibold text-gray-800">GoPay</span>
                </label>
                <!-- TRANSFER BANK -->
                <label @click="selectedMethod = 'bank'" :class="selectedMethod == 'bank' ? 'border-indigo-600 bg-indigo-50/50' : 'border-gray-200'" class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:border-indigo-600 transition">
                    <input type="radio" name="payment_method" value="bank" required class="text-indigo-600 focus:ring-indigo-500">
                    <span class="text-xs font-semibold text-gray-800">Transfer Bank</span>
                </label>
            </div>
        </div>

        <!-- Info Nomor Rekening / E-Wallet Berdasarkan Pilihan -->
        <div x-show="selectedMethod !== ''" x-transition class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-xs text-gray-700 space-y-1">
            <p class="font-semibold text-indigo-600 mb-1">Silakan transfer ke nomor berikut:</p>
            <template x-if="selectedMethod === 'dana'">
                <p>Nomor DANA: <strong>0857-0400-3309</strong> (a.n. SkillNest)</p>
            </template>
            <template x-if="selectedMethod === 'ovo'">
                <p>Nomor OVO: <strong>0857-0400-3309</strong> (a.n. SkillNest)</p>
            </template>
            <template x-if="selectedMethod === 'gopay'">
                <p>Nomor GoPay: <strong>0857-0400-3309</strong> (a.n. SkillNest)</p>
            </template>
            <template x-if="selectedMethod === 'bank'">
                <p>Bank BCA: <strong>1234-5678-90</strong> (a.n. SkillNest)</p>
            </template>
        </div>

        <!-- Upload Bukti Pembayaran -->
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-2">Upload Bukti Transfer / Screenshot</label>
            <input type="file" name="payment_proof" accept="image/*" required class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 border border-gray-200 rounded-xl p-2">
            <p class="text-[10px] text-gray-400 mt-1">Format: JPG, PNG (Maksimal 2MB).</p>
        </div>

        <button type="submit" class="w-full py-3 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
            Kirim Bukti Pembayaran
        </button>
    </form>
</div>
@endsection