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
        Schema::create('weekly_bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_pick_template_id')->constrained()->onDelete('cascade');
            $table->string('bet_text');
            $table->float('odd_yes');
            $table->float('odd_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_bets');
    }
};
