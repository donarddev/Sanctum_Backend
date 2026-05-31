<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rosary_progress', function (Blueprint $table) {
            $table->unique(['user_id', 'mystery_name'], 'rosary_progress_user_mystery_unique');
        });
    }

    public function down(): void
    {
        Schema::table('rosary_progress', function (Blueprint $table) {
            $table->dropUnique('rosary_progress_user_mystery_unique');
        });
    }
};