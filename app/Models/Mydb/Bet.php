<?php

namespace App\Models\Mydb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['player_id', 'bet_type', 'bet_amount'];
}
