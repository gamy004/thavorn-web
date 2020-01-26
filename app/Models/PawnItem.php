<?php

namespace App\Models;

use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PawnItem extends Model
{
    use SoftDeletes;

    const FK = 'pawn_item_id';

    protected $fillable = [
        DBCol::ITEM_WEIGHT,
        DBCol::ITEM_WEIGHT_UNIT,
        DBCol::ITEM_VALUE,
        DBCol::ITEM_VALUE_UNIT
    ];

    public function pawn()
    {
        return $this->belongsTo(Pawn::class, Pawn::FK);
    }

    public function updatePawn(Pawn $pawn)
    {
        $this->pawn()
            ->associate($pawn)
            ->save();

        return $this;
    }

    public function item_category()
    {
        return $this->belongsTo(
            ItemCategory::class,
            ItemCategory::FK
        );
    }

    public function updateItemCategoryById($item_category_id)
    {
        try {
            $item_category = ItemCategory::findOrFail($item_category_id);
            
            $this->updateItemCategory($item_category);
        } catch (ModelNotFoundException $exception) {
            throw new Exception("ItemCategory not found");
        }

        return $this;
    }

    public function updateItemCategory(
        ItemCategory $item_category
    ) {
        $this->item_category()
            ->associate($item_category)
            ->save();

        return $this;
    }

    public function item_damage()
    {
        return $this->belongsTo(
            ItemDamage::class,
            ItemDamage::FK
        );
    }

    public function updateItemDamageById($item_damage_id)
    {
        try {
            $item_damage = ItemDamage::findOrFail($item_damage_id);
            
            $this->updateItemDamage($item_damage);
        } catch (ModelNotFoundException $exception) {
            throw new Exception("ItemDamage not found");
        }

        return $this;
    }

    public function updateItemDamage(
        ItemDamage $item_damage
    ) {
        $this->item_damage()
            ->associate($item_damage)
            ->save();

        return $this;
    }
}
