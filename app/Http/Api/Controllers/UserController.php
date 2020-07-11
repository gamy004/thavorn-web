<?php

namespace App\Http\Api\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseApiController {
    public function update(Request $request, User $user)
    {
        return $this->api->update($user, $request->all());
    }
}