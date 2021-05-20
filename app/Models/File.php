<?php

namespace App\Models;

use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    
    const FK = 'file_id';

    protected $fillable = [
        DBCol::PATH,
        DBCol::ORIGINAL_NAME,
        DBCol::MIME,
        DBCol::EXTENSION
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_file', self::FK, User::FK)
                    ->using(UserFile::class);
    }
}
