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
        Schema::create('recruitment_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('ign');
            $table->string('delta_force_uid');
            $table->string('discord_tag');
            $table->foreignId('target_game_mode_id')->constrained('game_modes')->cascadeOnDelete();
            $table->enum('preferred_class', ['assault', 'engineer', 'support', 'recon'])->default('assault');
            $table->string('rank_tier');
            $table->string('proof_screenshot')->nullable();
            $table->enum('status', ['pending', 'under_review', 'accepted_trial', 'rejected'])->default('pending')->index();
            $table->text('reviewer_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_applications');
    }
};
