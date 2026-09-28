@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
    
    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <nav class="flex text-xs text-gray-500 mb-2 gap-2 items-center">
            <a href="{{ route('admin.webinars.index') }}" class="hover:text-indigo-600">Panel Admin</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-400"></i>
            <span class="text-gray-800 font-medium">Tambah Webinar</span>
        </nav>
        <h1 class="text-2xl font-extrabold text-gray-900">Buat Webinar Baru</h1>
        <p class="text-xs text-gray-500 mt-1">Isi informasi detail webinar, poster, dan deskripsi kegiatan yang akan ditayangkan ke publik.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm">
        <form action="{{ route('admin.webinars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Webinar -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Judul Webinar <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Mastering Laravel 11 for Beginners" 
                       class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Pemateri -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Pemateri / Speaker <span class="text-red-500">*</span></label>
                    <input type="text" name="speaker" value="{{ old('speaker') }}" required placeholder="Contoh: Alex Wijaya, Sr. Developer" 
                           class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                    @error('speaker') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="category" value="{{ old('category') }}" required placeholder="Contoh: Pemrograman, Desain, Karir" 
                           class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                    @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Tanggal -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date') }}" required 
                           class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                    @error('date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Waktu -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Waktu / Jam</label>
                    <input type="text" name="time" value="{{ old('time') }}" placeholder="Contoh: 19:00 WIB" 
                           class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                    @error('time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Biaya (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" min="0" placeholder="0 jika Gratis" 
                           class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                    @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Deskripsi Kegiatan -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Kegiatan <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" required placeholder="Tulis deskripsi acara, materi yang akan dipelajari, benefit, dan rangkaian kegiatan webinar..." 
                          class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition leading-relaxed">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Upload Poster / Pamflet -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Poster / Pamflet Kegiatan <span class="text-red-500">*</span></label>
                <div class="p-4 bg-gray-50 border border-dashed border-gray-300 rounded-2xl flex items-center justify-center text-center">
                    <input type="file" name="image" accept="image/*" required class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">
                </div>
                <span class="text-[11px] text-gray-400 mt-1 block">Format yang didukung: JPG, PNG, WEBP. Maksimal ukuran file 2MB.</span>
                @error('image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.webinars.index') }}" class="px-6 py-3 border border-gray-200 text-gray-600 font-bold text-xs rounded-xl hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-indigo-200 transition">
                    <i class="fas fa-save mr-1"></i> Simpan Webinar
                </button>
            </div>
        </form>
    </div>
</main>
@endsection