<?php

namespace App\Http\Api\Requests\PawnRequests;

use App\IOCs\DBCol;
use App\Models\User;
use App\Models\ItemDamage;
use App\Models\ItemCategory;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePawnRequest extends FormRequest
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
        $user_id = null;

        $rule_unique_id_card = Rule::unique('users', DBCol::IDENTITY_CARD_ID)
        ->where(function ($query) {
            $query->where('deleted_at', null);
        });

        $rule_unique_email = Rule::unique('users', DBCol::EMAIL)
        ->where(function ($query) {
            $query->where('deleted_at', null);
        });

        if ($this->pawn) {
            if ($this->pawn['user'] &&
                isset($this->pawn['user']['id'])
            ) {
                $user_id = $this->pawn['user']['id'];
            }
        }

        if (!is_null($user_id)) {
            $rule_unique_id_card->ignore($user_id);
            $rule_unique_email->ignore($user_id);
        }

        return [
            'pawn' => 'array',
            'pawn.user' => 'array',
            'pawn.user.' . DBCol::ID => [
                'numeric',
                'nullable',
                Rule::exists('users', DBCol::ID)
                ->where(function ($query) {
                    $query->where('deleted_at', null);
                }),
            ],

            'pawn.user.' . DBCol::FIRST_NAME => [
                'required',
                'string',
                'max:255'
            ],

            'pawn.user.' . DBCol::LAST_NAME => [
                'required',
                'string',
                'max:255'
            ],

            'pawn.user.'. DBCol::IDENTITY_CARD_ID => [
                'required',
                'string',
                'min:13',
                'max:13',
                $rule_unique_id_card,
            ],

            'pawn.user.' . DBCol::GENDER => [
                'required',
                Rule::in([User::MALE, User::FEMALE]),
            ],

            'pawn.user.' . DBCol::EMAIL => [
                'nullable',
                'email',
                'max:255',
                $rule_unique_email
            ],

            'pawn.pawn_items' => 'array',
            'pawn.pawn_items.*.' . DBCol::ID => [
                'numeric',
                'nullable',
                Rule::exists('pawn_items', DBCol::ID)
                ->where(function ($query) {
                    $query->where('deleted_at', null);
                }),
            ],
            'pawn.pawn_items.*.' . DBCol::ITEM_WEIGHT => 'required|numeric|min:0',
            'pawn.pawn_items.*.' . DBCol::ITEM_VALUE => 'required|numeric|min:0',
            'pawn.pawn_items.*.' . ItemCategory::FK => 'numeric|nullable|exists:item_categories,id',
            'pawn.pawn_items.*.' . ItemDamage::FK => 'numeric|nullable|exists:item_damages,id',

            'pawn.' . DBCol::INTEREST_RATE => 'required|numeric'
        ];
    }
}
