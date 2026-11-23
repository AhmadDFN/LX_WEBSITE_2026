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
        Schema::create('squads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_mode_id')->constrained('game_modes')->cascadeOnDelete();
            $table->foreignId('parent_squad_id')->nullable()->constrained('squads')->nullOnDelete();
            $table->unsignedTinyInteger('team_number')->nullable()->index();
            $table->string('squad_name');
            $table->foreignId('captain_id')->nullable()->constrained('player_profiles')->nullOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('squads');
    }
};
