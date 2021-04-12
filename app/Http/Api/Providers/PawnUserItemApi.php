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
    public function __construct(Pawn $q)
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
        $base_model = $this->getOriginalModel();

        $pawn_item_table = $base_model->getTable();
        $pawn_table = model_table(Pawn::class);
        $pawn_items_table = model_table(PawnItem::class);
        $user_table = model_table(User::class);

        $sub_query_count_name = 'sub_query_count_items';
        $sub_query_count = clone($base_model)
        ->leftJoin(
            $pawn_items_table,
            function($join) use ($pawn_table, $pawn_items_table) {
                $join->on(
                    sprintf('%s.%s', $pawn_table, DBCol::ID),
                    '=',
                    sprintf('%s.%s', $pawn_items_table, Pawn::FK)
                )->where(
                    sprintf('%s.%s', $pawn_items_table, DBCol::COMPLETE),
                    '=',
                    0
                );
            }
        )
        ->groupBy(sprintf('%s.%s', $pawn_table, DBCol::ID))
        ->select([
            sprintf('%s.%s as %s', $pawn_table, DBCol::ID, Pawn::FK),
            DB::raw(
                sprintf(
                    "COUNT(`%s`.%s) as %s",
                    $pawn_items_table,
                    DBCol::ID,
                    DBCol::COUNT_ITEMS
                )
            ),
            DB::raw(
                sprintf(
                    "SUM(`%s`.%s) as %s",
                    $pawn_items_table,
                    DBCol::ITEM_VALUE,
                    DBCol::TOTAL_ITEMS_VALUE
                )
            )
        ]);
        
        $query = $base_model->leftjoin(
            $user_table,
            sprintf('%s.%s', $pawn_table, Pawn::USER_FK),
            '=',
            sprintf('%s.%s', $user_table, DBCol::ID)
        )
        ->leftJoinSub(
            $sub_query_count,
            $sub_query_count_name,
            function($join) use ($pawn_table, $sub_query_count_name) {
                $join->on(
                    sprintf('%s.%s', $pawn_table, DBCol::ID),
                    '=',
                    sprintf('%s.%s', $sub_query_count_name, Pawn::FK)
                );
            }
        )
        ->select([
            sprintf('%s.*', $pawn_table),
            DB::raw(
                sprintf(
                    "CONCAT(`%s`.%s, ' ',`%s`.%s) as %s",
                    $user_table,
                    DBCol::FIRST_NAME,
                    $user_table,
                    DBCol::LAST_NAME,
                    DBCol::FULL_NAME
                )
            ),
            sprintf('%s.%s', $user_table, DBCol::IDENTITY_CARD_ID),
            sprintf('%s.%s', $sub_query_count_name, DBCol::COUNT_ITEMS),
            DB::raw(
                sprintf(
                    'IF(%s.%s IS NULL, 0, %s.%s) as %s',
                    $sub_query_count_name,
                    DBCol::TOTAL_ITEMS_VALUE,
                    $sub_query_count_name,
                    DBCol::TOTAL_ITEMS_VALUE,
                    DBCol::TOTAL_ITEMS_VALUE
                )
            )
        ]);
        
        return $query;
    }
}
