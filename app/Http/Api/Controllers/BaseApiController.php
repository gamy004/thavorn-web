<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Contracts\ApiInterface;

class BaseApiController extends Controller
{
    function __construct(ApiInterface $api)
    {
        $this->api = $api;
    }
}
