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
        Schema::create('squad_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('squad_id')->constrained('squads')->cascadeOnDelete();
            $table->foreignId('player_profile_id')->constrained('player_profiles')->cascadeOnDelete();
            $table->enum('slot_type', ['starter', 'substitute', 'reserve'])->default('starter')->index();
            $table->unsignedTinyInteger('sub_team_number')->nullable()->index();
            $table->string('role_specialization')->nullable();
            $table->timestamps();

            $table->unique(['squad_id', 'player_profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('squad_members');
    }
};
