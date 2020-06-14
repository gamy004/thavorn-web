<?php

namespace App\Http\Api\Controllers;

use App\Models\User;

class UserController extends BaseApiController {
    public function update(Request $request, User $user)
    {
        return $this->api->update($user, $request->all());
    }
}