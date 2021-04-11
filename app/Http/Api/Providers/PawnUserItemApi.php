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
        $user_table = model_table(User::class);

        $query = $base_model->leftjoin(
            $user_table,
            sprintf('%s.%s', $pawn_table, Pawn::USER_FK),
            '=',
            sprintf('%s.%s', $user_table, DBCol::ID)
        )
        ->select(
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
            sprintf('%s.%s', $user_table, DBCol::IDENTITY_CARD_ID)
        );
        
        return $query;
    }
}
