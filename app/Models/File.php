<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    
    const FK = 'file_id';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_file')
                    ->using(UserFile::class);
    }
}
