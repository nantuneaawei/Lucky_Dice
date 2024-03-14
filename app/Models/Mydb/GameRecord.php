<?php

namespace App\Models\Mydb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRecord extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['player_id', 'bet_id', 'game_result', 'profit_loss'];
}
