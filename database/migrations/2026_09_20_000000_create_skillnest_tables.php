<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom peran & status ke users (skip kalau sudah ada)
        Schema::table('users', function (Blueprint $t) {
            if (!Schema::hasColumn('users', 'peran')) {
                $t->string('peran')->default('Peserta');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $t->string('status')->default('Aktif');
            }
        });

        if (!Schema::hasTable('kategoris')) {
            Schema::create('kategoris', function (Blueprint $t) {
                $t->id();
                $t->string('nama')->unique();
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('organizers')) {
            Schema::create('organizers', function (Blueprint $t) {
                $t->id();
                $t->string('nama')->unique();
                $t->string('kontak');
                $t->string('verifikasi')->default('Menunggu');
                $t->timestamps();
            });
        }

        // Struktur webinars lama tidak dipakai lagi -> hapus & buat ulang
        // (foreign key dari tabel lain seperti webinar_materials dimatikan sementara)
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('webinars');
        Schema::create('webinars', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->foreignId('kategori_id')->constrained('kategoris')->restrictOnDelete();
            $t->foreignId('organizer_id')->constrained('organizers')->restrictOnDelete();
            $t->string('tipe')->default('Gratis');
            $t->unsignedInteger('harga')->default(0);
            $t->date('tanggal');
            $t->time('waktu');
            $t->unsignedInteger('kuota');
            $t->unsignedInteger('terisi')->default(0);
            $t->timestamps();
            // kolom 'status' sengaja TIDAK dibuat di sini, ditambahkan oleh migration berikutnya
        });

        Schema::enableForeignKeyConstraints();

        if (!Schema::hasTable('transaksis')) {
            Schema::create('transaksis', function (Blueprint $t) {
                $t->id();
                $t->string('peserta');
                $t->foreignId('webinar_id')->constrained('webinars')->restrictOnDelete();
                $t->unsignedBigInteger('jumlah')->default(0);
                $t->date('tanggal');
                $t->string('status')->default('Menunggu');
                $t->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
        Schema::dropIfExists('webinars');
        Schema::dropIfExists('organizers');
        Schema::dropIfExists('kategoris');
        Schema::table('users', function (Blueprint $t) {
            if (Schema::hasColumn('users', 'peran')) $t->dropColumn('peran');
            if (Schema::hasColumn('users', 'status')) $t->dropColumn('status');
        });
    }
};