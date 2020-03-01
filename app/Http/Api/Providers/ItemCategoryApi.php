<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\DBCol;
use App\Models\ItemCategory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Api\Contracts\ApiInterface;

class ItemCategoryApi extends BaseApi implements ApiInterface
{

    public function __construct(ItemCategory $q)
    {
        parent::__construct($q);
    }
}
