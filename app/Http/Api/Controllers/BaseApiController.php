<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Contracts\ApiInterface;
use App\Models\User;

class BaseApiController extends Controller
{
    function __construct(ApiInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->api->index();
    }

    public function show(User $user)
    {
        return $this->api->show($user);
    }

    public function store(Request $request)
    {
        return $this->api->store($request->all());
    }

    public function update(Request $request, User $user)
    {
        return $this->api->update($user, $request->all());
    }

    public function destroy(User $user)
    {
        return $this->api->destroy($user);
    }

    public function restore($id)
    {
        return $this->api->restore($id);
    }
}
