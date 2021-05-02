<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\DBCol;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Http\Api\Contracts\ApiInterface;

class FileApi extends BaseApi implements ApiInterface
{
    public function __construct(File $q)
    {
        parent::__construct($q);
    }

    public function upload(UploadedFile $fileRequest, $directory = 'files', User $user = null)
    {
        if ($fileRequest->isValid()) {
            $filepath = $fileRequest->store($directory.'/'.$user->{DBCol::IDENTITY_CARD_ID});

            $file = File::create([
                DBCol::PATH => $filepath,
                DBCol::ORIGINAL_NAME => $fileRequest->getClientOriginalName(),
                DBCol::EXTENSION => $fileRequest->clientExtension(),
                DBCol::MIME => $fileRequest->getMimeType()
            ]);

            if (!is_null($user)) {
                $file->users()->attach($user->id);
            }
                
            return $file;
        }
    }

    public function download(File $file)
    {
        return Storage::download($file->{DBCol::PATH});
    }
}
