<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saints', function (Blueprint $table) {
            $table->index(['feast_month', 'feast_day'], 'saints_feast_month_feast_day_index');
        });
    }

    public function down(): void
    {
        Schema::table('saints', function (Blueprint $table) {
            $table->dropIndex('saints_feast_month_feast_day_index');
        });
    }
};