<?php

namespace App\Rules;

use App\Models\Pawn;
use Illuminate\Contracts\Validation\Rule;

class CloseAmount implements Rule
{
    protected $pawn;
    protected $checked_amount;
    protected $paid_amount;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Pawn $pawn)
    {
        $this->pawn = $pawn;
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

        $close_payment = $this->pawn->getClosePayment();

        if (isset($close_payment[Data::CLOSE_AMOUNT])) {
            $this->paid_amount = $close_payment[Data::CLOSE_AMOUNT];
        }

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
