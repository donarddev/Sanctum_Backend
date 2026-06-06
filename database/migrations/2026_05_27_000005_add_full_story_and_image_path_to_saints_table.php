<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saints', function (Blueprint $table) {
            $table->longText('full_story')->nullable();
            $table->string('image_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('saints', function (Blueprint $table) {
            $table->dropColumn(['full_story', 'image_path']);
        });
    }
};