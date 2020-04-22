<?php

namespace App\Models;

use Carbon\Carbon;
use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pawn extends Model
{
    use SoftDeletes;
    
    const FK = 'pawn_id';
    const USER_FK = 'customer_id';
    
    protected static function boot() {
        parent::boot();
    
        static::deleting(function($pawn) {
            // soft delete each item
            $pawn->pawn_items()->each(
                function($pawn_item) {
                    $pawn_item->delete();
                }
            );
        });

        static::restoring(function($pawn) {
            // restore each item
            $pawn->pawn_items()
                ->withTrashed()
                ->each(
                    function($pawn_item) {
                        $pawn_item->restore();
                    }
                );
        });
    }

    protected $fillable = [
        DBCol::PAWN_NO,
        DBCol::INTEREST_RATE,
        DBCol::LATEST_PAID_AT,
        DBCol::NEXT_PAID_AT
    ];

    public function user()
    {
        return $this->belongsTo(User::class, self::USER_FK);
    }

    public function pawn_items()
    {
        return $this->hasMany(PawnItem::class, self::FK);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, self::FK);
    }

    public function updateCustomer(User $user)
    {
        $this->user()
            ->associate($user)
            ->save();

        return $this;
    }

    public function interest_factor()
    {
        return $this->{DBCol::INTEREST_RATE}/100;
    }

    public function computePaidAmount($num_month = 1)
    {
        $total_item_values = $this->pawn_items()
            ->incomplete()
            ->sum(DBCol::ITEM_VALUE);

        return round($total_item_values * $this->interest_factor() * $num_month, 2);
    }

    public function getPaidTime()
    {
        $time = $this->{DBCol::NEXT_PAID_AT};

        // If next paid at is null, use created_at as the latest datetime
        if (is_null($time)) {
            $time = $this->{DBCol::CREATED_AT};
        }

        return $time;
    }

    public function getNewPaidTime($num_month = 1)
    {
        $time = $this->getPaidTime();

        return [
            DBCol::TIME_START_AT => Carbon::make($time),
            DBCol::TIME_END_AT => Carbon::make($time)->addMonths($num_month)
        ];
    }

    public function pay($amount, $month)
    {
        $new_time_paid  = $this->getNewPaidTime($month);
        $time_start_at  = $new_time_paid[DBCol::TIME_START_AT];
        $time_end_at    = $new_time_paid[DBCol::TIME_END_AT];

        $this->payments()->create([
            DBCol::AMOUNT => $amount,
            DBCol::MONTH_AMOUNT => $month,
            DBCol::TIME_START_AT => $new_time_paid[DBCol::TIME_START_AT]->toDatetimeString(),
            DBCol::TIME_END_AT => $new_time_paid[DBCol::TIME_END_AT]->toDatetimeString(),
        ]);

        $this->update([
            DBCol::LATEST_PAID_AT => Carbon::now()->toDatetimeString(),
            DBCol::NEXT_PAID_AT => $new_time_paid[DBCol::TIME_END_AT]->toDatetimeString()
        ]);
            
        $this->load("payments");

        return $this;
    }
}
