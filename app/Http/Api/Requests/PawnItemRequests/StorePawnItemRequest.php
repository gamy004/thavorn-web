<?php

namespace App\Http\Api\Requests\PawnItemRequests;

use App\IOCs\DBCol;
use App\Models\ItemCategory;
use Illuminate\Foundation\Http\FormRequest;

class StorePawnItemRequest extends FormRequest
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
            'item_weight' => 'required|numeric',
            'item_value' => 'required|numeric',
            'pawn_id' => 'required|exists:pawns,id',
            'item_category_id' => 'sometimes|required|exists:item_categories,id',
            'item_damage_id' => 'sometimes|required|exists:item_damages,id'
        ];
    }
}
