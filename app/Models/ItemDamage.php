<?php

namespace App\Models;

use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemDamage extends Model
{
    use SoftDeletes;
    
    const FK = 'item_damage_id';

    protected $fillable = [
        DBCol::ITEM_DAMAGE
    ];

    public function pawn_items()
    {
        return $this->hasMany(PawnItem::class, self::FK);
    }
}
