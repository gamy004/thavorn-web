<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\Data;
use Carbon\Carbon;
use App\IOCs\DBCol;
use App\Models\Pawn;
use App\Models\Role;
use App\Models\User;
use App\Models\Payment;
use App\Models\PawnItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
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
        if (
            isset($raw["amount"]) &&
            isset($raw["month_amount"]) &&
            isset($raw["time_start_at"]) &&
            isset($raw["time_end_at"])
        ) {
            $pawn->pay(
                $raw["amount"],
                $raw["month_amount"],
                $raw["time_start_at"],
                $raw["time_end_at"]
            );
        }

        return $pawn;
    }

    public function close(Pawn $pawn, array $raw = []) {
        if (isset($raw["amount"])) {
            $pawn->close($raw["amount"]);
        }

        return $pawn;
    }

    public function getPaidAmount(Pawn $pawn, array $raw = []) {
        if (isset($raw["month_amount"])) {
            return [
                Data::PAID_AMOUNT => $pawn->computePaidAmount(
                    $raw["month_amount"]
                )
            ];
        }
    }

    public function getCloseAmount(Pawn $pawn, array $raw = []) {
        return $pawn->getClosePayment();
    }

    public function getSummary(array $raw=[])
    {
        $base_model = $this->getOriginalModel();

        $pawn_table = model_table(Pawn::class);
        $pawn_items_table = model_table(PawnItem::class);
        $payment_table = model_table(Payment::class);

        $complete_field = DBCol::COMPLETE;
        $item_value_field = DBCol::ITEM_VALUE;
        $month_amount_field = DBCol::MONTH_AMOUNT;
        $id_field = DBCol::ID;
        $deleted_at_field = DBCol::DELETED_AT;

        $total_close_query_name = 'queryTotalCloseValue';
        $total_close_query = $base_model->leftJoin(
            $payment_table,
            function($join) use ($pawn_table, $payment_table, $deleted_at_field) {
                $join->on(
                    sprintf('%s.%s', $pawn_table, DBCol::ID),
                    '=',
                    sprintf('%s.%s', $payment_table, Pawn::FK)
                )->whereNull("$payment_table.$deleted_at_field");
            }
        )
        ->where(sprintf('%s.%s', $pawn_table, $complete_field), 1)
        ->when(isset($raw['time_start_at']), function ($query) use ($raw, $payment_table) {
            $query->where(
                sprintf('%s.%s', $payment_table, DBCol::CREATED_AT),
                '>=',
                Carbon::make($raw['time_start_at'])->toDatetimeString()
            );
        })
        ->when(isset($raw['time_end_at']), function ($query) use ($raw, $payment_table) {
            $query->where(
                sprintf('%s.%s', $payment_table, DBCol::CREATED_AT),
                '<',
                Carbon::make($raw['time_end_at'])->addDay()->toDatetimeString()
            );
        })
        ->select([
            DB::raw("SUM($payment_table.amount) as complete_total_close_value")
        ])
        ->first();

        $total_query = $base_model->leftJoin(
            $pawn_items_table,
            function($join) use ($pawn_table, $pawn_items_table, $deleted_at_field) {
                $join->on(
                    sprintf('%s.%s', $pawn_table, DBCol::ID),
                    '=',
                    sprintf('%s.%s', $pawn_items_table, Pawn::FK)
                )->whereNull("$pawn_items_table.$deleted_at_field");
            }
        )
        ->when(isset($raw['time_start_at']), function ($query) use ($raw, $pawn_items_table) {
            $query->where(
                sprintf('%s.%s', $pawn_items_table, DBCol::CREATED_AT),
                '>=',
                Carbon::make($raw['time_start_at'])->toDatetimeString()
            );
        })
        ->when(isset($raw['time_end_at']), function ($query) use ($raw, $pawn_items_table) {
            $query->where(
                sprintf('%s.%s', $pawn_items_table, DBCol::CREATED_AT),
                '<',
                Carbon::make($raw['time_end_at'])->addDay()->toDatetimeString()
            );
        })
        ->select([
            DB::raw("SUM($pawn_items_table.$item_value_field) as total_item_value"),
            DB::raw("SUM(IF($pawn_items_table.$complete_field = 1, 0, $pawn_items_table.$item_value_field)) as incomplete_total_item_value")
        ])
        ->first();

        return [
            "total_item_value" => $total_query->total_item_value,
            "incomplete_total_item_value" => $total_query->incomplete_total_item_value,
            "complete_total_close_value" => $total_close_query->complete_total_close_value
        ];
    }

    public function generateNumber() {
        return [
            DBCol::PAWN_NO => $this->getOriginalModel()->generate_no()
        ];
    }
}
