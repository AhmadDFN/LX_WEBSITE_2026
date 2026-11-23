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
        if (!Schema::hasTable('tournaments')) {
            Schema::create('tournaments', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('organizer')->nullable();
                $table->foreignId('game_mode_id')->nullable()->constrained('game_modes')->nullOnDelete();
                $table->foreignId('squad_id')->nullable()->constrained('squads')->nullOnDelete();
                $table->string('prize_pool')->nullable();
                $table->enum('tournament_format', ['single_elimination', 'double_elimination', 'group_stage', 'round_robin', 'custom'])->default('single_elimination');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->enum('status', ['upcoming', 'ongoing', 'completed', 'canceled'])->default('upcoming')->index();
                $table->string('placement')->nullable(); // e.g. "Champion 1st", "Runner Up 2nd", "Top 4"
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tournament_matches')) {
            Schema::create('tournament_matches', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
                $table->string('round_name'); // e.g. "Quarter Finals", "Semi Finals", "Grand Final", "Group A - Match 1"
                $table->unsignedInteger('match_order')->default(1);
                $table->foreignId('squad_id')->nullable()->constrained('squads')->nullOnDelete();
                $table->string('opponent_name');
                $table->string('opponent_logo')->nullable();
                $table->unsignedSmallInteger('our_score')->default(0);
                $table->unsignedSmallInteger('opponent_score')->default(0);
                $table->enum('status', ['scheduled', 'ongoing', 'won', 'lost'])->default('scheduled')->index();
                $table->dateTime('scheduled_at')->nullable();
                $table->string('stream_url')->nullable();
                $table->string('vod_url')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_matches');
        Schema::dropIfExists('tournaments');
    }
};
