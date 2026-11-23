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
        Schema::create('scrim_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrim_match_id')->constrained('scrim_matches')->cascadeOnDelete();
            $table->foreignId('player_profile_id')->constrained('player_profiles')->cascadeOnDelete();
            $table->enum('status', ['attending', 'tentative', 'absent'])->default('tentative')->index();
            $table->string('reason')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            $table->unique(['scrim_match_id', 'player_profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrim_attendances');
    }
};
