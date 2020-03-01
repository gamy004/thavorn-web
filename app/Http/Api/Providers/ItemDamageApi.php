<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\DBCol;
use App\Models\ItemDamage;
use Illuminate\Database\Eloquent\Model;
use App\Http\Api\Contracts\ApiInterface;

class ItemDamageApi extends BaseApi implements ApiInterface
{

    public function __construct(ItemDamage $q)
    {
        parent::__construct($q);
    }
}
