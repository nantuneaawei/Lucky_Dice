<?php

namespace App\Models\Mydb;

use Database\Factories\BetFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['player_id', 'bet_type', 'bet_content', 'bet_amount', 'game_result', 'profit_loss'];

    protected static function newFactory()
    {
        return BetFactory::new();
    }
}
