<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('feast_month');
            $table->unsignedTinyInteger('feast_day');
            $table->string('title')->nullable();
            $table->text('short_story');
            $table->string('virtue')->nullable();
            $table->text('life_lesson')->nullable();
            $table->text('prayer')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saints');
    }
};