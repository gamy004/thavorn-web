<?php

namespace App\Models;

use App\IOCs\DBCol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    const FK = 'role_id';

    protected $fillable = [
        DBCol::ROLE
    ];

    public function users()
    {
        return $this->hasMany(User::class, self::FK);
    }

    public function scopeCustomer($query)
    {
        return $query->firstOrCreate([
            DBCol::ROLE => "customer"
        ]);
    }
}
