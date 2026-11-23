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
        Schema::create('player_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ign')->unique();
            $table->string('delta_force_uid')->nullable()->unique();
            $table->enum('player_type', ['competitive', 'casual', 'trial'])->default('casual')->index();
            $table->enum('preferred_class', ['assault', 'engineer', 'support', 'recon'])->default('assault')->index();
            $table->string('rank_tier')->nullable();
            $table->string('discord_tag')->nullable();
            $table->string('avatar_url')->nullable();
            $table->enum('status', ['active', 'inactive', 'benched'])->default('active')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_profiles');
    }
};
