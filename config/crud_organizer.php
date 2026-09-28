<?php

use App\Models\{Kategori, Webinar};

// Format sama dengan config/crud.php, tapi tanpa organizer_id dan terisi (diatur sistem).
return [
    'webinar' => [
        'model' => Webinar::class, 'label' => 'Webinar', 'icon' => 'cal', 'sub' => 'Kelola webinar milik organisasi Anda.',
        'with' => ['kategori'], 'search' => ['judul'], 'filter' => 'status',
        'fields' => [
            ['judul', 'Judul webinar', 'text', 'required|string|max:150'],
            ['kategori_id', 'Kategori', 'ref', 'required|exists:kategoris,id', Kategori::class, 'nama'],
            ['tipe', 'Tipe', 'select', 'required|in:Gratis,Berbayar', ['Gratis', 'Berbayar']],
            ['harga', 'Harga (Rp)', 'number', 'required_if:tipe,Berbayar|nullable|integer|min:0'],
            ['tanggal', 'Tanggal', 'date', 'required|date'],
            ['waktu', 'Waktu', 'time', 'required'],
            ['kuota', 'Kuota', 'number', 'required|integer|min:1'],
            ['status', 'Status', 'select', 'required|in:Draft,Published,Selesai', ['Draft', 'Published', 'Selesai']],
        ],
        'columns' => [['judul', 'Judul Webinar'], ['kategori.nama', 'Kategori', 'badge'], ['tipe', 'Tipe', 'badge'], ['harga', 'Harga', 'rp'], ['tanggal', 'Tanggal', 'date'], ['terisi', 'Pendaftar', 'fill'], ['status', 'Status', 'badge']],
    ],
];