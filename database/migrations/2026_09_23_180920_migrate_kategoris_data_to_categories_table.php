<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Lepas dulu foreign key lama yang masih nunjuk ke tabel 'kategoris'
        Schema::table('webinars', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
        });

        // 2. Pemetaan nama di tabel lama 'kategoris' -> slug di tabel baru 'categories'
        $map = [
            'Lainnya' => 'lainnya',
            'Pendidikan & Karier' => 'pendidikan-karir',
            'Desain & UI/UX' => 'desain-uiux',
            'Bisnis & Keuangan' => 'bisnis-keuangan',
            'Pengembangan Diri' => 'pengembangan-diri',
            'Teknologi & Pemrograman' => 'teknologi-coding',
            'Digital Marketing' => 'digital-marketing',
        ];

        $kategoris = DB::table('kategoris')->get();

        foreach ($kategoris as $kat) {
            $slug = $map[$kat->nama] ?? null;

            if (!$slug) {
                continue; // skip kalau ada nama yang gak dikenali, biar aman
            }

            $newCategory = DB::table('categories')->where('slug', $slug)->first();

            if (!$newCategory) {
                continue;
            }

            // Update semua webinar yang masih pakai kategori_id lama,
            // ganti ke id yang benar di tabel categories
            DB::table('webinars')
                ->where('kategori_id', $kat->id)
                ->update(['kategori_id' => $newCategory->id]);
        }

        // 3. Hapus 3 kategori duplikat/legacy yang gak dipakai webinar manapun
        DB::table('categories')->whereIn('slug', [
            'technology-code', 'ui-ux-design', 'business-marketing',
        ])->delete();

        // 4. Setelah data dipindah dan dicek aman, hapus tabel kategoris lama
        Schema::dropIfExists('kategoris');

        // 5. Pasang foreign key baru yang nunjuk ke tabel categories
        Schema::table('webinars', function (Blueprint $table) {
            $table->foreign('kategori_id')->references('id')->on('categories')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        // Migration data ini sengaja tidak dibuat reversible,
        // karena sifatnya pemindahan data, bukan perubahan struktur murni.
    }
};