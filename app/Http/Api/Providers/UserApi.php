<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\DBCol;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Http\Api\Contracts\ApiInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserApi extends BaseApi implements ApiInterface
{
    protected $fields = [
        DBCol::USERNAME,
        DBCol::FIRST_NAME,
        DBCol::LAST_NAME,
        DBCol::EMAIL,
        DBCol::ROLE_ID
    ];

    public function __construct(User $q)
    {
        parent::__construct($q);
    }

    public function beforeStore(array $raw = [])
    {
        $raw = $this->parsePassword($raw);

        return $raw;
    }

    public function beforeUpdate(Model $model, array $raw = [])
    {
        $raw = $this->parsePassword($raw);

        return [$model, $raw];
    }

    private function parsePassword(array $raw = [])
    {
        if (isset($raw[DBCol::PASSWORD])) {
            $raw[DBCol::PASSWORD] = Hash::make($raw[DBCol::PASSWORD]);
        }

        return $raw;
    }
}
