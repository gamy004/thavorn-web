<?php

namespace App\Models;

use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    const FK = 'pawn_item_id';

    protected $fillable = [
        DBCol::AMOUNT,
        DBCol::MONTH_AMOUNT,
        DBCol::TIME_START_AT,
        DBCol::TIME_END_AT
    ];

    public function pawn()
    {
        return $this->belongsTo(Pawn::class, Pawn::FK);
    }
}
