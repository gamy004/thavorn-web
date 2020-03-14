<?php

namespace App\Http\Api\Requests\PawnItemRequests;

use App\IOCs\DBCol;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePawnItemRequest extends FormRequest
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

        ];
    }
}
