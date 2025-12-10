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
        Schema::table('test_sessions', function (Blueprint $table) {
            $table->decimal('score_twk', 5, 2)->nullable()->after('score');
            $table->decimal('score_tiu', 5, 2)->nullable()->after('score_twk');
            $table->decimal('score_tkp', 5, 2)->nullable()->after('score_tiu');
            $table->longText('shuffled_questions')->nullable()->after('answers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_sessions', function (Blueprint $table) {
            $table->dropColumn(['score_twk', 'score_tiu', 'score_tkp', 'shuffled_questions']);
        });
    }
};
