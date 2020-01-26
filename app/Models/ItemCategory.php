<?php

namespace App\Models;

use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemCategory extends Model
{
    use SoftDeletes;
    
    const FK = 'item_category_id';

    protected $fillable = [
        DBCol::ITEM_CATEGORY
    ];

    public function pawn_items()
    {
        return $this->hasMany(PawnItem::class, self::FK);
    }
}
