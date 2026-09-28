<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizers', function (Blueprint $t) {
            $t->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
            $t->string('telepon')->nullable();
            $t->string('dokumen_path')->nullable();          // file di storage privat
            $t->text('alasan_penolakan')->nullable();
            $t->timestamp('diverifikasi_at')->nullable();
            $t->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('organizers', function (Blueprint $t) {
            $t->dropConstrainedForeignId('diverifikasi_oleh');
            $t->dropConstrainedForeignId('user_id');
            $t->dropColumn(['telepon', 'dokumen_path', 'alasan_penolakan', 'diverifikasi_at']);
        });
    }
};