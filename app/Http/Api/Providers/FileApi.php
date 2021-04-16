<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\DBCol;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use App\Http\Api\Contracts\ApiInterface;

class FileApi extends BaseApi implements ApiInterface
{
    public function __construct(File $q)
    {
        parent::__construct($q);
    }

    public function upload()
    {
        
    }
}
