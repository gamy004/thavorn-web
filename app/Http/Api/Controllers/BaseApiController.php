<?php

namespace App\Http\Api\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Api\Contracts\ApiInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function show($id)
    {
        return $this->api->find($id);
    }

    public function store(Request $request)
    {
        return $this->api->store($request->all());
    }

    public function update(Request $request, $id)
    {
        $model = $this->api->find($id)->first();
        
        if (is_null($model)) {
            throw new ModelNotFoundException("Model not found", 1);   
        }

        return $this->api->update($model, $request->all());
    }

    public function destroy($id)
    {
        $model = $this->api->find($id)->first();

        if (is_null($model)) {
            throw new ModelNotFoundException("Model not found", 1);   
        }

        return $this->api->destroy($model);
    }

    public function restore($id)
    {
        return $this->api->restore($id);
    }
}
