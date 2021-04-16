<?php

namespace App\Http\Api\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;

class FileController extends BaseApiController
{
    public function uploadEvidence(Request $request, User $user)
    {
        $fileRequest = $request->file('file');
        
        if ($fileRequest->isValid()) {
            $filepath = $fileRequest->storeAs('files');

            $file = File::create([
                'path' => $filepath,
                'original_name' => $fileRequest->getClientOriginalName(),
                'extension' => $fileRequest->clientExtension(),
            ]);

            
        }
    }
}
