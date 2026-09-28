@extends('layouts.app')

@section('content')

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

    <!-- CARD UTAMA -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">

        <!-- ========================================================= -->
        <!-- HEADER -->
        <!-- ========================================================= -->
        <div class="flex items-center justify-between w-full gap-6 mb-6">

            <!-- BAGIAN JUDUL -->
            <div class="flex-1 min-w-0">

                <h3 class="text-lg font-bold text-gray-900">
                    Kelola Webinar
                </h3>

                <p class="text-xs text-gray-500 mt-1">
                    Tambah, lihat, ubah, dan hapus webinar beserta poster dan deskripsinya.
                </p>

            </div>


            <!-- ===================================================== -->
            <!-- SEARCH + FILTER + TAMBAH -->
            <!-- ===================================================== -->

            <div
                class="flex items-center gap-3 flex-nowrap"
                style="
                    display: flex !important;
                    flex-direction: row !important;
                    flex-wrap: nowrap !important;
                    align-items: center !important;
                    white-space: nowrap !important;
                "
            >

                <!-- SEARCH -->
                <div
                    class="relative flex-shrink-0"
                    style="width: 220px;"
                >

                    <!-- ICON SEARCH -->
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">

                        <i class="fas fa-search text-xs"></i>

                    </span>


                    <!-- INPUT -->
                    <input
                        type="text"
                        placeholder="Cari webinar..."
                        class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600"
                    >

                </div>


                <!-- FILTER STATUS -->
                <div
                    class="flex-shrink-0"
                    style="width: 135px;"
                >

                    <select
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        <option value="aktif">
                            Aktif
                        </option>

                        <option value="selesai">
                            Selesai
                        </option>

                    </select>

                </div>


                <!-- TOMBOL TAMBAH -->
                <a
                    href="{{ route('admin.webinars.create') }}"
                    class="flex-shrink-0 inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-700 transition-colors shadow-sm"
                >

                    <i class="fas fa-plus"></i>

                    <span>
                        Tambah Webinar
                    </span>

                </a>

            </div>

        </div>



        <!-- ========================================================= -->
        <!-- TABEL -->
        <!-- ========================================================= -->

        <div class="overflow-x-auto">

            <table class="w-full text-left text-xs whitespace-nowrap">

                <!-- HEADER TABEL -->
                <thead>

                    <tr class="border-b border-gray-100 text-gray-400 uppercase font-semibold text-[10px]">

                        <th class="py-3 px-3">
                            No
                        </th>

                        <th class="py-3 px-3">
                            Poster
                        </th>

                        <th class="py-3 px-3">
                            Judul & Deskripsi
                        </th>

                        <th class="py-3 px-3">
                            Kategori
                        </th>

                        <th class="py-3 px-3">
                            Tipe
                        </th>

                        <th class="py-3 px-3">
                            Harga
                        </th>

                        <th class="py-3 px-3">
                            Tanggal
                        </th>

                        <th class="py-3 px-3">
                            Pendaftar
                        </th>

                        <th class="py-3 px-3">
                            Status
                        </th>

                        <th class="py-3 px-3 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>



                <!-- BODY -->
                <tbody class="divide-y divide-gray-100">

                    @forelse($webinars ?? [] as $index => $webinar)

                        <tr class="hover:bg-gray-50/50 transition-colors">

                            <!-- NO -->
                            <td class="py-3 px-3 text-gray-500">
                                {{ $loop->iteration }}
                            </td>


                            <!-- POSTER -->
                            <td class="py-3 px-3">

                                <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden border border-gray-200 flex-shrink-0">

                                    @if($webinar->image)

                                        <img
                                            src="{{ Str::startsWith($webinar->image, 'http')
                                                ? $webinar->image
                                                : asset('storage/' . $webinar->image) }}"
                                            class="w-full h-full object-cover"
                                            alt="Poster Webinar"
                                        >

                                    @else

                                        <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-medium">
                                            No Image
                                        </div>

                                    @endif

                                </div>

                            </td>


                            <!-- JUDUL DAN DESKRIPSI -->
                            <td class="py-3 px-3 max-w-xs whitespace-normal">

                                <div class="font-bold text-gray-900 truncate">

                                    {{ $webinar->title }}

                                </div>

                                <div class="text-[11px] text-gray-500 line-clamp-1 mt-0.5">

                                    {{ $webinar->description }}

                                </div>

                            </td>


                            <!-- KATEGORI -->
                            <td class="py-3 px-3 text-gray-700">

                                {{ $webinar->category }}

                            </td>


                            <!-- TIPE -->
                            <td class="py-3 px-3 text-gray-700">

                                {{ $webinar->type ?? 'Online' }}

                            </td>


                            <!-- HARGA -->
                            <td class="py-3 px-3 text-gray-700">

                                @if($webinar->price > 0)

                                    Rp {{ number_format($webinar->price, 0, ',', '.') }}

                                @else

                                    Gratis

                                @endif

                            </td>


                            <!-- TANGGAL -->
                            <td class="py-3 px-3 text-gray-700">

                                {{ $webinar->date }}

                            </td>


                            <!-- PENDAFTAR -->
                            <td class="py-3 px-3 text-gray-700">

                                {{ $webinar->pendaftar_count ?? 0 }} Orang

                            </td>


                            <!-- STATUS -->
                            <td class="py-3 px-3">

                                <span
                                    class="px-2.5 py-1 text-[10px] font-semibold rounded-full
                                    {{ ($webinar->status ?? 'aktif') == 'aktif'
                                        ? 'bg-emerald-50 text-emerald-600'
                                        : 'bg-gray-100 text-gray-600'
                                    }}"
                                >

                                    {{ ucfirst($webinar->status ?? 'Aktif') }}

                                </span>

                            </td>


                            <!-- AKSI -->
                            <td class="py-3 px-3 text-center">

                                <div class="inline-flex items-center justify-center gap-1.5">

                                    <!-- DETAIL -->
                                    <a
                                        href="#"
                                        class="w-8 h-8 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 flex items-center justify-center transition-colors shadow-sm"
                                        title="Detail"
                                    >

                                        <i class="fas fa-eye text-xs"></i>

                                    </a>


                                    <!-- EDIT -->
                                    <a
                                        href="{{ route('admin.webinars.edit', $webinar->id) }}"
                                        class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 flex items-center justify-center transition-colors shadow-sm"
                                        title="Edit"
                                    >

                                        <i class="fas fa-edit text-xs"></i>

                                    </a>


                                    <!-- HAPUS -->
                                    <form
                                        action="{{ route('admin.webinars.destroy', $webinar->id) }}"
                                        method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Yakin ingin menghapus webinar ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-colors shadow-sm"
                                            title="Hapus"
                                        >

                                            <i class="fas fa-trash-alt text-xs"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <!-- JIKA DATA KOSONG -->
                        <tr>

                            <td
                                colspan="10"
                                class="py-8 text-center text-gray-400 text-xs"
                            >

                                Belum ada data webinar.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>

@endsection