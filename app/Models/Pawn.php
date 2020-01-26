<?php

namespace App\Models;

use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pawn extends Model
{
    use SoftDeletes;
    
    const FK = 'pawn_id';
    const USER_FK = 'customer_id';

    protected $fillable = [
        DBCol::INTEREST_RATE
    ];

    public function user()
    {
        return $this->belongsTo(User::class, self::USER_FK);
    }

    public function pawn_items()
    {
        return $this->hasMany(PawnItem::class, self::FK);
    }

    public function updateCustomer(User $user)
    {
        $this->user()
            ->associate($user)
            ->save();

        return $this;
    }
}
