<?php

namespace App\Http\Api\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Api\Contracts\ApiInterface;
use App\Http\Api\Contracts\StoreFormRequestInterface;
use App\Http\Api\Contracts\UpdateFormRequestInterface;

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

    public function show(Model $model)
    {
        return $this->api->show($model);
    }

    public function store(StoreFormRequestInterface $request)
    {
        return $this->api->store($request->all());
    }

    public function update(UpdateFormRequestInterface $request, Model $model)
    {
        return $this->api->update($model, $request->all());
    }

    public function destroy(Model $model)
    {
        return $this->api->destroy($model);
    }

    public function restore($id)
    {
        return $this->api->restore($id);
    }
}
