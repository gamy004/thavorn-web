<?php

namespace App\Models;

use Carbon\Carbon;
use App\IOCs\Data;
use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pawn extends Model
{
    use SoftDeletes;
    
    const FK = 'pawn_id';
    const USER_FK = 'customer_id';
    const INTEREST_RATE_ONE_DAY = 1; #percent
    const MINIMUM_INTEREST = 30; #baht

    protected static function boot() {
        parent::boot();
        
        static::creating(function($pawn) {
            $pawn->{DBCol::PAWN_NO} = static::generate_no();
        });

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
        DBCol::NEXT_PAID_AT,
        DBCol::COMPLETE
    ];

    static function generate_no()
    {
        $delimeter = '/';
        $limit_prefix = 99;
        $limit_suffix = 9999;
        $latest_pawn = self::select([DBCol::PAWN_NO])->orderBy(DBCol::ID, 'desc')->first();

        if (is_null($latest_pawn)) {
            $prefix = 1;
            $suffix = 1;
        } else {
            $prefix_suffix = explode($delimeter, $latest_pawn->{DBCol::PAWN_NO});

            $prefix = intval($prefix_suffix[0]);
            $suffix = intval($prefix_suffix[1]);

            $reach_limit_prefix = $prefix == $limit_prefix;
            $reach_limit_suffix = $suffix == $limit_suffix;

            if ($reach_limit_prefix && $reach_limit_suffix) {
                $prefix = 1;
                $suffix = 1;
            } else {
                $prefix = $reach_limit_suffix ? $prefix + 1 : $prefix;
                $suffix = $reach_limit_suffix ? 1 : $suffix + 1;
            }
        }
        
        return str_pad($prefix, 2, '0', STR_PAD_LEFT).$delimeter.str_pad($suffix, 4, '0', STR_PAD_LEFT);
    }

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

    public function interest_rate_one_day_factor()
    {
        return static::INTEREST_RATE_ONE_DAY/100;
    }

    public function interest_factor()
    {
        return $this->{DBCol::INTEREST_RATE}/100;
    }

    public function computePawnItemsValue()
    {
        return floatval(
            $this->pawn_items()
                ->incomplete()
                ->sum(DBCol::ITEM_VALUE)
        );
    }

    public function computePaidAmount($num_month = 0)
    {
        $total_item_values = $this->computePawnItemsValue();

        return round($total_item_values * $this->interest_factor() * $num_month, 2);
    }

    public function latestPayment()
    {
        return $this->payments()->orderBy('created_at', 'desc')->limit(1)->first();
    }

    public function getPaidTime()
    {
        $time = null;

        $latest_payment = $this->latestPayment();

        // dd($latest_payment);

        if (!is_null($latest_payment)) {
            $time = $latest_payment->{DBCol::TIME_END_AT};
        }

        // dd($time);

        // If next paid at is null, use created_at as the latest datetime
        if (is_null($time)) {
            $time = $this->{DBCol::CREATED_AT};
        }

        return $time;
    }
    
    public function getDueMonthDay()
    {   
        $time = $this->getPaidTime();

        $latest = Carbon::make($time);

        $current = Carbon::now();
        
        // if ($current->lt($latest)) {
        //     $latest_payment = $this->latestPayment();

        //     if (!is_null($latest_payment)) {
        //         $current = Carbon::make($latest_payment->{DBCol::TIME_END_AT});
        //     }
        // }

        $diff_day = $latest->diffInDays($current, false);
        
        $due_month = 0;
        $due_day = 0;
        // dump($diff_day);
        if ($diff_day > 0) {
            // set initial counter
            $next_month_latest = Carbon::make($time)->addMonth();
            $next_month_diff_day = $latest->diffInDays($next_month_latest, false);
            // dump($next_month_latest, $latest, $next_month_diff_day);

            // Count month by adding one month until $next_month_diff_day greater than $diff_day
            while ($next_month_diff_day <= $diff_day) {
                $due_month += 1;
                $next_month_latest->addMonth();
                $next_month_diff_day = $latest->diffInDays($next_month_latest, false);
                // dump($next_month_latest, $latest, $next_month_diff_day);
            }

            // Use $due_month to find the previous month to calculate $due_day
            $latest_month = Carbon::make($time)->addMonths($due_month);
            $due_day = $latest_month->diffInDays($current, false);
        } else {
            // set initial counter
            $next_month_latest = Carbon::make($time)->subMonth();
            $next_month_diff_day = $latest->diffInDays($next_month_latest, false);
            // dump($next_month_latest, $latest, $next_month_diff_day);

            // Count month by subing one month until $next_month_diff_day greater than $diff_day
            while ($next_month_diff_day >= $diff_day) {
                $due_month -= 1;
                $next_month_latest->subMonth();
                $next_month_diff_day = $latest->diffInDays($next_month_latest, false);
                // dump($next_month_latest, $latest, $next_month_diff_day);
            }

            // Use $due_month to find the previous month to calculate $due_day
            $latest_month = Carbon::make($time)->subMonths(abs($due_month));
            $due_day = $latest_month->diffInDays($current, false);
        }

        // dd($due_month, $due_day);
        
        return compact('due_month', 'due_day');
    }

    public function getClosePayment()
    {
        $over_due_month_interest = null;
        $due_month_day = $this->getDueMonthDay();
        $pawn_items_value = $this->computePawnItemsValue();
        $count_payments = $this->payments()->count();

        $due_month = abs($due_month_day['due_month']);
        $due_day = abs($due_month_day['due_day']);
        $is_due_month_exceed = $due_month_day['due_month'] < 0;
        $is_due_day_exceed = $due_month_day['due_day'] < 0;

        if (
            $due_month === 0 &&
            $due_day === 0 &&
            $count_payments === 0
        ) {
            // Case: one day
            $interest_value = $pawn_items_value * $this->interest_rate_one_day_factor();
        } else {
            $interest_value = $this->computePaidAmount($due_month);

            if ($is_due_month_exceed) {
                $interest_value = -1 * $interest_value;
            }
        }
        
        // Case: least than one month
        if ($due_day > 0) {
            $divider = $due_day > 15 ? 1 : 2;
            $due_day_interest = $this->computePaidAmount(1) / $divider;
            
            if (!is_null($due_day_interest)) {
                if ($is_due_day_exceed) {
                    $due_day_interest = -1 * $due_day_interest;
                }

                $interest_value += $due_day_interest;
            }
        }
        
        if ($interest_value > 0 && $interest_value < self::MINIMUM_INTEREST) {
            $interest_value = self::MINIMUM_INTEREST;
        }
        
        $close_payment_amount = $pawn_items_value + $interest_value;
        
        return [
            Data::CLOSE_AMOUNT => round($close_payment_amount, 2),
            Data::TOTAL_ITEMS_VALUE => round($pawn_items_value, 2),
            Data::INTEREST_VALUE => round($interest_value, 2)
        ];
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

        return $this;
    }

    public function close($amount)
    {
        $due_month_day = $this->getDueMonthDay();
        $due_month = $due_month_day['due_month'];
        $new_time_paid  = $this->getNewPaidTime($due_month);
        $time_start_at  = $new_time_paid[DBCol::TIME_START_AT];
        $time_end_at    = $new_time_paid[DBCol::TIME_END_AT];

        $this->payments()->create([
            DBCol::AMOUNT => $amount,
            DBCol::MONTH_AMOUNT => $due_month,
            DBCol::TIME_START_AT => $new_time_paid[DBCol::TIME_START_AT]->toDatetimeString(),
            DBCol::TIME_END_AT => $new_time_paid[DBCol::TIME_END_AT]->toDatetimeString(),
        ]);

        $this->update([
            DBCol::LATEST_PAID_AT => Carbon::now()->toDatetimeString(),
            DBCol::NEXT_PAID_AT => null,
            DBCol::COMPLETE => true
        ]);

        $this->pawn_items()->update([
            DBCol::COMPLETE => true
        ]);

        return $this;
    }
}
