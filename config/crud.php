<?php

use App\Models\{Category, Organizer, Transaksi, User, Webinar};

/*
 | Format field : [nama, label, tipe, aturan_validasi, opsi/model, kolom_label]
 | tipe         : text | email | number | date | time | select | ref | password
 | Format kolom : [atribut, label, format]  format: badge | rp | date | fill
 | {id} pada aturan validasi diganti id data yang sedang diubah (untuk unique).
 */
return [
    'webinar' => [
        'model' => Webinar::class, 'label' => 'Webinar', 'icon' => 'cal', 'sub' => 'Tambah, lihat, ubah, dan hapus webinar.',
        'with' => ['kategori', 'organizer'], 'search' => ['judul'], 'filter' => 'status', 'guard' => 'transaksis',
        'fields' => [
            ['judul', 'Judul webinar', 'text', 'required|string|max:150'],
            ['kategori_id', 'Kategori', 'ref', 'required|exists:categories,id', Category::class, 'name'],
            ['organizer_id', 'Organizer', 'ref', 'required|exists:organizers,id', Organizer::class, 'nama'],
            ['tipe', 'Tipe', 'select', 'required|in:Gratis,Berbayar', ['Gratis', 'Berbayar']],
            ['harga', 'Harga (Rp)', 'number', 'required_if:tipe,Berbayar|nullable|integer|min:0'],
            ['tanggal', 'Tanggal', 'date', 'required|date'],
            ['waktu', 'Waktu', 'time', 'required'],
            ['kuota', 'Kuota', 'number', 'required|integer|min:1'],
            ['terisi', 'Jumlah pendaftar', 'number', 'required|integer|min:0|lte:kuota'],
            ['status', 'Status', 'select', 'required|in:Published,Draft,Selesai', ['Published', 'Draft', 'Selesai']],
        ],
        'columns' => [['judul', 'Judul Webinar'], ['kategori.name', 'Kategori', 'badge'], ['tipe', 'Tipe', 'badge'], ['harga', 'Harga', 'rp'], ['tanggal', 'Tanggal', 'date'], ['terisi', 'Pendaftar', 'fill'], ['status', 'Status', 'badge']],
    ],
    'category' => [
        'model' => Category::class, 'label' => 'Kategori', 'icon' => 'folder', 'sub' => 'Atur kategori webinar.',
        'search' => ['name'], 'guard' => 'webinars', 'count' => ['webinars'],
        'fields' => [['name', 'Nama kategori', 'text', 'required|string|max:80|unique:categories,name,{id}']],
        'columns' => [['name', 'Nama Kategori'], ['webinars_count', 'Jumlah Webinar']],
    ],
    'pengguna' => [
        'model' => User::class, 'label' => 'Pengguna', 'icon' => 'users', 'sub' => 'Kelola akun peserta, organizer, dan admin.',
        'search' => ['name', 'email'], 'filter' => 'status',
        'fields' => [
            ['name', 'Nama lengkap', 'text', 'required|string|max:100'],
            ['email', 'Email', 'email', 'required|email|unique:users,email,{id}'],
            ['peran', 'Peran', 'select', 'required|in:Peserta,Organizer,Admin', ['Peserta', 'Organizer', 'Admin']],
            ['status', 'Status', 'select', 'required|in:Aktif,Nonaktif', ['Aktif', 'Nonaktif']],
            ['password', 'Password', 'password', ''],
        ],
        'columns' => [['name', 'Nama'], ['email', 'Email'], ['peran', 'Peran'], ['status', 'Status', 'badge']],
    ],
    'organizer' => [
        'model' => Organizer::class, 'label' => 'Organizer', 'icon' => 'cal', 'sub' => 'Verifikasi dan kelola penyelenggara webinar.',
        'search' => ['nama', 'kontak'], 'filter' => 'verifikasi', 'guard' => 'webinars', 'count' => ['webinars'],
        'fields' => [
            ['nama', 'Nama organizer', 'text', 'required|string|max:100|unique:organizers,nama,{id}'],
            ['kontak', 'Email kontak', 'email', 'required|email'],
            ['verifikasi', 'Verifikasi', 'select', 'required|in:Terverifikasi,Menunggu,Ditolak', ['Terverifikasi', 'Menunggu', 'Ditolak']],
        ],
        'columns' => [['nama', 'Nama Organizer'], ['kontak', 'Kontak'], ['webinars_count', 'Jumlah Webinar'], ['verifikasi', 'Verifikasi', 'badge']],
    ],
    'transaksi' => [
        'model' => Transaksi::class, 'label' => 'Transaksi', 'icon' => 'card', 'sub' => 'Pantau dan atur pembayaran peserta.',
        'with' => ['webinar'], 'search' => ['peserta'], 'filter' => 'status',
        'fields' => [
            ['peserta', 'Nama peserta', 'text', 'required|string|max:100'],
            ['webinar_id', 'Webinar', 'ref', 'required|exists:webinars,id', Webinar::class, 'judul'],
            ['jumlah', 'Jumlah (Rp)', 'number', 'required|integer|min:0'],
            ['tanggal', 'Tanggal', 'date', 'required|date'],
            ['status', 'Status', 'select', 'required|in:Berhasil,Menunggu,Gagal', ['Berhasil', 'Menunggu', 'Gagal']],
        ],
        'columns' => [['peserta', 'Peserta'], ['webinar.judul', 'Webinar'], ['jumlah', 'Jumlah', 'rp'], ['tanggal', 'Tanggal', 'date'], ['status', 'Status', 'badge']],
    ],
];