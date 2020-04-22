<?php

namespace App\Rules;

use App\Models\Pawn;
use Illuminate\Contracts\Validation\Rule;

class PaidAmount implements Rule
{
    protected $pawn;
    protected $checked_month_amount;
    protected $checked_amount;
    protected $paid_amount;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Pawn $pawn, $checked_month_amount)
    {
        $this->pawn = $pawn; 
        $this->checked_month_amount = $checked_month_amount;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $amount)
    {
        $this->checked_amount = $amount;
        $this->paid_amount = $this->pawn->computePaidAmount(
            $this->checked_month_amount
        );

        return $this->checked_amount == $this->paid_amount;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Given amount $this->checked_amount is incorrect, the accepted amount is $this->paid_amount";
    }
}
