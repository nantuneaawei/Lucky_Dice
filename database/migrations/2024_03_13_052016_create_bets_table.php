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
            $table->unsignedBigInteger('player_id')->comment('玩家ID');
            $table->string('bet_type')->comment('下注類型');
            $table->string('bet_content')->comment('下注內容');
            $table->decimal('bet_amount', 10, 2)->comment('下注金額');
            $table->string('game_result')->nullable()->comment('遊戲結果');
            $table->decimal('profit_loss', 10, 2)->nullable()->comment('損益結果');
            $table->timestamp('createdAt')->useCurrent();
            $table->timestamp('updatedAt')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::table('bets', function (Blueprint $table) {
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
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
