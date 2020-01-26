<?php

namespace App\Models;

use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;

class Pawn extends Model
{
    protected $fillable = [
        DBCol::INTEREST_RATE
    ];
}
