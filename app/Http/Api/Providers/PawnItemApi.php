<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\DBCol;
use App\Models\Pawn;
use App\Models\PawnItem;
use App\Models\ItemDamage;
use App\Models\ItemCategory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Api\Contracts\ApiInterface;

class PawnItemApi extends BaseApi implements ApiInterface
{
    protected $itemCategoryApi;
    protected $itemDamageApi;

    public function __construct(PawnItem $q)
    {
        parent::__construct($q);
    }

    protected function stored(PawnItem $model, array $raw = [], array $record = [])
    {
        $model = $this->updateItemCategory($model, $raw);
        $model = $this->updateItemDamage($model, $raw);

        return $model;
    }

    protected function updated(PawnItem $model, array $raw = [], array $record = [])
    {
        $model = $this->updateItemCategory($model, $raw);
        $model = $this->updateItemDamage($model, $raw);

        return $model;
    }

    public function createOrUpdateItem(array $raw = [])
    {
        if (isset($raw[DBCol::ID])) {
            $item = PawnItem::findOrFail($raw[DBCol::ID]);

            $item = $this->update($item, $raw)->first();
        } else {
            $item = $this->store($raw)->first();
        }

        return $item;
    }

    protected function updateItemCategory(Model $model, array $raw = [])
    {
        if (isset($raw[ItemCategory::FK])) {
            $item_category_id = $raw[ItemCategory::FK];

            $model->updateItemCategoryById($item_category_id);
        }

        return $model;
    }

    protected function updateItemDamage(Model $model, array $raw = [])
    {
        if (isset($raw[ItemDamage::FK])) {
            $item_damage_id = $raw[ItemDamage::FK];

            $model->updateItemDamageById($item_damage_id);
        }


        return $model;
    }
}
