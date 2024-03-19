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
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('bet_id');
            $table->string('bet_type');
            $table->string('bet_content');
            $table->decimal('bet_amount', 10, 2);
            $table->string('game_result')->nullable();
            $table->decimal('profit_loss', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::table('bets', function (Blueprint $table) {
            $table->foreign('bet_id')->references('id')->on('bets')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bets');
    }
};
