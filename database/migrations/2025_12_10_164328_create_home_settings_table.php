<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('Seleksi CPNS 2025');
            $table->text('hero_subtitle')->default('Platform Persiapan Ujian CPNS Terpercaya');
            $table->text('hero_description')->nullable();
            $table->string('cta_button_text')->default('Mulai Sekarang');
            $table->text('welcome_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
