<?php

namespace App\Http\Api\Controllers;

use App\Models\PawnItem;
use App\Http\Api\Requests\PawnItemRequests\StorePawnItemRequest;
use App\Http\Api\Requests\PawnItemRequests\UpdatePawnItemRequest;

class PawnItemController extends BaseApiController
{
    public function store(StorePawnItemRequest $request)
    {
        return $this->api->store($request->all());
    }

    public function update(UpdatePawnItemRequest $request, PawnItem $pawn_item)
    {
        return $this->api->update($pawn_item, $request->all());
    }
}
