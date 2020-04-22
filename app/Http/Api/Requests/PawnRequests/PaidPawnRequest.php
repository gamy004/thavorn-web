<?php

namespace App\Http\Api\Requests\PawnRequests;

use App\Rules\PaidAmount;
use Illuminate\Foundation\Http\FormRequest;

class PaidPawnRequest extends FormRequest
{
    /**
     * Determine if the Pawn is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'month_amount' => 'required|numeric|min:0',
            'amount' => ['required', 'numeric', 'min:0', new PaidAmount($this->pawn, $this->month_amount)],
        ];
    }
}
