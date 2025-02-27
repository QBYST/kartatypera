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
        Schema::create('weekly_pick_outcomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_pick_template_id')->constrained()->onDelete('cascade');
            $table->json('team_outcomes');
            $table->json('rider_outcomes');
            $table->json('h2h_outcomes');
            $table->json('bet_outcomes');
            $table->integer('week');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_pick_outcomes');
    }
};
