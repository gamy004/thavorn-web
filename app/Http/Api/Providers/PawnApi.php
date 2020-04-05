<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\DBCol;
use App\Models\Pawn;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Http\Api\Contracts\ApiInterface;

class PawnApi extends BaseApi implements ApiInterface
{
    protected $userApi;
    protected $pawnItemApi;

    public function __construct(Pawn $q, UserApi $userApi, PawnItemApi $pawnItemApi)
    {
        parent::__construct($q);

        $this->userApi = $userApi;
        $this->pawnItemApi = $pawnItemApi;
    }

    protected function beforeStore(array $raw = [])
    {
        if (!isset($raw[DBCol::PAWN_NO])) {
            $raw[DBCol::PAWN_NO] = Str::uuid()->toString();
        }

        return $raw;
    }

    protected function stored(Model $model, array $raw = [], array $record = [])
    {
        $model = $this->updateUser($model, $raw);
        $model = $this->updateItems($model, $raw);

        return $model;
    }

    protected function updated(Model $model, array $raw = [], array $record = [])
    {
        $model = $this->updateUser($model, $raw);
        $model = $this->updateItems($model, $raw);

        return $model;
    }

    public function updateUser(Model $model, array $raw = [])
    {
        if (isset($raw["user"])) {
            $customer_data = $raw["user"];
            
            $customer = $this->userApi->createOrUpdateCustomer($customer_data);
            
            $model = $model->updateCustomer($customer);
        }

        return $model;
    }

    public function updateItems(Model $model, array $raw = [])
    {
        if (isset($raw["pawn_items"])) {
            $pawn_items_data = $raw["pawn_items"];

            $pawn_items = [];

            foreach ($pawn_items_data as $key => $pawn_item_data) {
                $pawn_item = $this->pawnItemApi->createOrUpdateItem($pawn_item_data);

                array_push($pawn_items, $pawn_item);
            }

            if (!empty($pawn_items)) {
                $model->pawn_items()->saveMany($pawn_items);
            }
        }

        return $model;
    }
}
