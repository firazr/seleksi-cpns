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
        Schema::create('test_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('domisili_penempatan');
            $table->string('category'); // TWK, TIU, TKP, or 'full'
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->integer('score')->nullable();
            $table->json('answers')->nullable(); // Store user's answers
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_sessions');
    }
};
