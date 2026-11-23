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
        Schema::create('match_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrim_match_id')->unique()->constrained('scrim_matches')->cascadeOnDelete();
            $table->integer('our_score')->default(0);
            $table->integer('opponent_score')->default(0);
            $table->enum('result', ['win', 'lose', 'draw'])->index();
            $table->json('maps_played')->nullable();
            $table->string('vod_url')->nullable();
            $table->string('screenshot_url')->nullable();
            $table->foreignId('mvp_player_id')->nullable()->constrained('player_profiles')->nullOnDelete();
            $table->text('coach_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_results');
    }
};
