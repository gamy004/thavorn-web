<?php

namespace App\Http\Api\Controllers;

use App\Models\Pawn;
use App\Http\Api\Requests\PawnRequests\PaidPawnRequest;
use App\Http\Api\Requests\PawnRequests\ClosePawnRequest;
use App\Http\Api\Requests\PawnRequests\StorePawnRequest;
use App\Http\Api\Requests\PawnRequests\UpdatePawnRequest;

class PawnController extends BaseApiController {
    public function store(StorePawnRequest $request)
    {
        return $this->api->store($request->pawn);
    }

    public function update(UpdatePawnRequest $request, Pawn $pawn)
    {
        return $this->api->update($pawn, $request->pawn);
    }

    public function pay(PaidPawnRequest $request, Pawn $pawn)
    {
        return $this->api->pay($pawn, $request->all());
    }

    public function close(ClosePawnRequest $request, Pawn $pawn)
    {
        return $this->api->close($pawn, $request->all());
    }
}