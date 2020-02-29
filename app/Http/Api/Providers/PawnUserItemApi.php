<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\DBCol;
use App\Models\Pawn;
use App\Models\PawnItem;
use App\Models\ItemCategory;
use App\Models\ItemDamage;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Http\Api\Contracts\ApiInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PawnUserItemApi extends BaseApi implements ApiInterface
{
    public function __construct(PawnItem $q)
    {
        parent::__construct($q);
    }

    public function index() {

        $this->setCustomQuery(
            $this->queryIndex()
        );

        return parent::index();
    }

    private function queryIndex() {
        $pawn_item_model = $this->getOriginalModel();

        $pawn_item_table = $pawn_item_model->getTable();
        $pawn_table = model_table(Pawn::class);
        $user_table = model_table(User::class);
        $item_damage_table = model_table(ItemDamage::class);
        $item_category_table = model_table(ItemCategory::class);

        $query = $pawn_item_model->join(
            $pawn_table,
            sprintf('%s.%s', $pawn_item_table, Pawn::FK),
            '=',
            sprintf('%s.%s', $pawn_table, DBCol::ID)
        )->leftjoin(
            $user_table,
            sprintf('%s.%s', $pawn_table, Pawn::USER_FK),
            '=',
            sprintf('%s.%s', $user_table, DBCol::ID)
        )->leftjoin(
            $item_damage_table,
            sprintf('%s.%s', $pawn_item_table, ItemDamage::FK),
            '=',
            sprintf('%s.%s', $item_damage_table, DBCol::ID)
        )->leftjoin(
            $item_category_table,
            sprintf('%s.%s', $pawn_item_table, ItemCategory::FK),
            '=',
            sprintf('%s.%s', $item_category_table, DBCol::ID)
        )->select(
            sprintf('%s.*', $pawn_item_table),
            sprintf('%s.%s', $user_table, DBCol::FIRST_NAME),
            sprintf('%s.%s', $user_table, DBCol::LAST_NAME),
            sprintf('%s.%s', $pawn_table, DBCol::PAWN_NO),
            sprintf('%s.%s', $pawn_table, Pawn::USER_FK),
            sprintf('%s.%s', $user_table, DBCol::IDENTITY_CARD_ID),
            sprintf('%s.%s', $item_damage_table, DBCol::ITEM_DAMAGE),
            sprintf('%s.%s', $item_category_table, DBCol::ITEM_CATEGORY)
        );

        return $query;
    }
}
