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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'peserta'])->default('peserta')->after('password');
            $table->string('nik', 16)->unique()->nullable()->after('role');
            $table->string('domisili')->nullable()->after('nik');
            $table->string('ttl')->nullable()->after('domisili'); // Tempat, Tanggal Lahir
            $table->string('photo_path')->nullable()->after('ttl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nik', 'domisili', 'ttl', 'photo_path']);
        });
    }
};
