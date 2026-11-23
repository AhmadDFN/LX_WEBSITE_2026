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
        Schema::create('scrim_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_mode_id')->constrained('game_modes')->cascadeOnDelete();
            $table->foreignId('squad_id')->nullable()->constrained('squads')->nullOnDelete();
            $table->string('opponent_name');
            $table->string('opponent_logo')->nullable();
            $table->enum('match_type', ['scrim', 'tournament', 'exhibition'])->default('scrim')->index();
            $table->date('match_date')->index();
            $table->time('match_time');
            $table->enum('format', ['BO1', 'BO3', 'BO5'])->default('BO3');
            $table->string('room_id')->nullable();
            $table->string('room_password')->nullable();
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'canceled'])->default('scheduled')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrim_matches');
    }
};
