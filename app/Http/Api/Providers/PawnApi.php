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

    protected function stored(Pawn $pawn, array $raw = [], array $record = [])
    {
        $pawn = $this->updateUser($pawn, $raw);
        $pawn = $this->updateItems($pawn, $raw);

        return $pawn;
    }

    protected function updated(Pawn $pawn, array $raw = [], array $record = [])
    {
        $pawn = $this->updateUser($pawn, $raw);
        $pawn = $this->updateItems($pawn, $raw);

        return $pawn;
    }

    public function updateUser(Pawn $pawn, array $raw = [])
    {
        if (isset($raw["user"])) {
            $customer_data = $raw["user"];
            
            $customer = $this->userApi->createOrUpdateCustomer($customer_data);
            
            $pawn = $pawn->updateCustomer($customer);
        }

        return $pawn;
    }

    public function updateItems(Pawn $pawn, array $raw = [])
    {
        if (isset($raw["pawn_items"])) {
            $pawn_items_data = $raw["pawn_items"];

            $pawn_items = [];

            foreach ($pawn_items_data as $key => $pawn_item_data) {
                $pawn_item = $this->pawnItemApi->createOrUpdateItem($pawn_item_data);

                array_push($pawn_items, $pawn_item);
            }

            if (!empty($pawn_items)) {
                $pawn->pawn_items()->saveMany($pawn_items);
            }
        }

        return $pawn;
    }

    public function pay(Pawn $pawn, array $raw = []) {
        if (isset($raw["amount"]) && isset($raw["month_amount"])) {
            $pawn->pay($raw["amount"], $raw["month_amount"]);
        }

        return $pawn;
    }
}
