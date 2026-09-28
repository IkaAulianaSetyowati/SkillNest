@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- HEADER ADMIN -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-xl font-extrabold text-gray-900">Dashboard System Admin</h1>
                <span class="bg-indigo-100 text-indigo-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">SUPER ADMIN</span>
            </div>
            <p class="text-xs text-gray-500 mt-0.5">Kelola pengguna, moderasi konten, dan kontrol seluruh sistem platform</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="px-3.5 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-xl shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
                <i class="fas fa-download"></i> Ekspor Laporan System
            </button>
            <button onclick="openModal('modalUserAdmin')" class="px-3.5 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl shadow-md shadow-indigo-100 hover:bg-indigo-700 transition flex items-center gap-2">
                <i class="fas fa-user-plus"></i> Tambah User Baru
            </button>
        </div>
    </div>

    <!-- CARDS STATISTIK UTAMA SYSTEM -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-gray-400">Total User Terdaftar</p>
                <h3 class="text-xl font-extrabold text-gray-800 mt-0.5">12,480</h3>
                <span class="text-[10px] font-bold text-emerald-600"><i class="fas fa-arrow-up"></i> +15% bulan ini</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                <i class="fas fa-users-cog"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-gray-400">Total Akun Organizer</p>
                <h3 class="text-xl font-extrabold text-gray-800 mt-0.5">142</h3>
                <span class="text-[10px] font-bold text-emerald-600"><i class="fas fa-check-circle"></i> 8 Pengajuan Baru</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-sm">
                <i class="fas fa-user-tie"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-gray-400">Total Event & Grup</p>
                <h3 class="text-xl font-extrabold text-gray-800 mt-0.5">86</h3>
                <span class="text-[10px] font-bold text-gray-400">Aktif Berjalan</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-gray-400">Laporan & Violations</p>
                <h3 class="text-xl font-extrabold text-gray-800 mt-0.5">5</h3>
                <span class="text-[10px] font-bold text-red-500"><i class="fas fa-exclamation-triangle"></i> Perlu Tindakan</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-sm">
                <i class="fas fa-shield-alt"></i>
            </div>
        </div>
    </div>

    <!-- KONTEN UTAMA TABLE & MODERASI -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- KELOLA USER & ROLE PLATFORM -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <h2 class="text-sm font-extrabold text-gray-800">Manajemen Pengguna Platform</h2>
                <div class="flex items-center gap-2">
                    <input type="text" placeholder="Cari nama / email..." class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <select class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-gray-600 focus:outline-none">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="organizer">Organizer</option>
                        <option value="user">User biasa</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-600">
                    <thead class="bg-slate-50 text-gray-400 uppercase text-[10px]">
                        <tr>
                            <th class="p-3 rounded-l-xl">Pengguna</th>
                            <th class="p-3">Role</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right rounded-r-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="p-3 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-[10px]">AD</div>
                                <div>
                                    <p class="font-bold text-gray-800">Aris Dev</p>
                                    <p class="text-[10px] text-gray-400">aris@example.com</p>
                                </div>
                            </td>
                            <td class="p-3">
                                <span class="bg-purple-50 text-purple-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Admin</span>
                            </td>
                            <td class="p-3"><span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2.5 py-1 rounded-full">Aktif</span></td>
                            <td class="p-3 text-right space-x-1">
                                <button class="px-2.5 py-1 bg-slate-100 text-gray-600 font-bold text-[10px] rounded-lg hover:bg-slate-200">Edit</button>
                            </td>
                        </tr>

                        <tr>
                            <td class="p-3 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-[10px]">BS</div>
                                <div>
                                    <p class="font-bold text-gray-800">Budi Event Tech</p>
                                    <p class="text-[10px] text-gray-400">budi@organizer.com</p>
                                </div>
                            </td>
                            <td class="p-3">
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Organizer</span>
                            </td>
                            <td class="p-3"><span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2.5 py-1 rounded-full">Aktif</span></td>
                            <td class="p-3 text-right space-x-1">
                                <button class="px-2.5 py-1 bg-slate-100 text-gray-600 font-bold text-[10px] rounded-lg hover:bg-slate-200">Edit Role</button>
                                <button class="px-2.5 py-1 bg-red-50 text-red-600 font-bold text-[10px] rounded-lg hover:bg-red-100">Banned</button>
                            </td>
                        </tr>

                        <tr>
                            <td class="p-3 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-[10px]">SR</div>
                                <div>
                                    <p class="font-bold text-gray-800">Siti Rahma</p>
                                    <p class="text-[10px] text-gray-400">siti@example.com</p>
                                </div>
                            </td>
                            <td class="p-3">
                                <span class="bg-slate-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full">User</span>
                            </td>
                            <td class="p-3"><span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2.5 py-1 rounded-full">Aktif</span></td>
                            <td class="p-3 text-right space-x-1">
                                <button class="px-2.5 py-1 bg-slate-100 text-gray-600 font-bold text-[10px] rounded-lg hover:bg-slate-200">Edit Role</button>
                                <button class="px-2.5 py-1 bg-red-50 text-red-600 font-bold text-[10px] rounded-lg hover:bg-red-100">Banned</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LAPORAN MODERASI KONTEN PLATFORM -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-extrabold text-gray-800">Antrean Moderasi</h2>
                <span class="bg-red-100 text-red-600 text-[10px] font-extrabold px-2 py-0.5 rounded-full">3 Laporan</span>
            </div>
            
            <div class="space-y-3">
                <div class="p-3 bg-red-50/50 border border-red-100 rounded-2xl space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="bg-red-100 text-red-600 text-[9px] font-extrabold px-2 py-0.5 rounded-full">Indikasi Spam</span>
                        <span class="text-[10px] text-gray-400">10m yang lalu</span>
                    </div>
                    <p class="text-xs text-gray-700 font-medium">Postingan oleh <b>@user_spammer</b> mengandung tautan phishing judi online.</p>
                    <div class="flex justify-end gap-2 pt-1 border-t border-red-100">
                        <button class="text-[10px] font-bold text-gray-500 hover:underline">Abaikan</button>
                        <button class="text-[10px] font-bold text-red-600 hover:underline">Hapus & Banned</button>
                    </div>
                </div>

                <div class="p-3 bg-amber-50/50 border border-amber-100 rounded-2xl space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="bg-amber-100 text-amber-700 text-[9px] font-extrabold px-2 py-0.5 rounded-full">Pengajuan Organizer</span>
                        <span class="text-[10px] text-gray-400">1 jam yang lalu</span>
                    </div>
                    <p class="text-xs text-gray-700 font-medium"><b>Dev Community Jakarta</b> mengajukan verifikasi akun Organizer.</p>
                    <div class="flex justify-end gap-2 pt-1 border-t border-amber-100">
                        <button class="text-[10px] font-bold text-red-600 hover:underline">Tolak</button>
                        <button class="text-[10px] font-bold text-emerald-600 hover:underline">Setujui (Verify)</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL TAMBAH USER / ADMIN BARU -->
<div id="modalUserAdmin" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl relative space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <h3 class="text-sm font-extrabold text-gray-900">Tambah Pengguna / Admin Baru</h3>
            <button onclick="closeModal('modalUserAdmin')" class="text-gray-400 hover:text-gray-600 text-sm"><i class="fas fa-times"></i></button>
        </div>

        <form onsubmit="return false;" class="space-y-3.5">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" placeholder="Masukkan nama pengguna" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Email</label>
                <input type="email" placeholder="email@example.com" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Role Akses</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="user">User biasa</option>
                    <option value="organizer">Organizer Event/Grup</option>
                    <option value="admin">System Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Password Sementara</label>
                <input type="password" placeholder="••••••••" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex items-center justify-end gap-3 pt-3">
                <button type="button" onclick="closeModal('modalUserAdmin')" class="px-4 py-2 text-xs font-bold text-gray-500 hover:bg-slate-50 rounded-xl">Batal</button>
                <button type="submit" onclick="closeModal('modalUserAdmin')" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-100 transition">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection