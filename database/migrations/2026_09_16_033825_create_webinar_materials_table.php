<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('webinar_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->constrained('webinars')->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['video', 'file', 'link']);
            $table->string('file_path')->nullable();
            $table->text('external_url')->nullable();
            $table->boolean('is_downloadable')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('webinar_materials');
    }
};