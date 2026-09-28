<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->text('description_en')->nullable()->after('description');
            $table->string('bg_color')->nullable()->after('icon');
        });
    }

    public function down(): void {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'description_en', 'bg_color']);
        });
    }
};