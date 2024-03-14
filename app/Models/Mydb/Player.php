<?php

namespace App\Models\Mydb;

use Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['username', 'email', 'password', 'balance'];

    protected static function newFactory()
    {
        return PlayerFactory::new();
    }
}
