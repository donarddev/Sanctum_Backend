<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_reflections', function (Blueprint $table) {
            $table->id();
            $table->date('reflection_date')->unique()->nullable();
            $table->string('title');
            $table->string('bible_reference');
            $table->text('bible_excerpt');
            $table->text('reflection');
            $table->text('action_step')->nullable();
            $table->text('prayer')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_reflections');
    }
};