<?php

namespace App\Models\Mydb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['username', 'password', 'balance'];
}
