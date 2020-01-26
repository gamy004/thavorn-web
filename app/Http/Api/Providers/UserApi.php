<?php

namespace App\Http\Api\Providers;

use Exception;
use App\IOCs\DBCol;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Http\Api\Contracts\ApiInterface;

class UserApi extends BaseApi implements ApiInterface
{
    public function __construct(User $q)
    {
        parent::__construct($q);
    }

    protected function beforeStore(array $raw = [])
    {
        $raw = $this->parsePassword($raw);

        return $raw;
    }

    protected function stored(Model $model, array $raw = [], array $record = [])
    {
        $model = $this->updateRole($model, $raw);

        return $model;
    }

    public function beforeUpdate(Model $model, array $raw = [])
    {
        $raw = $this->parsePassword($raw);

        return [$model, $raw];
    }

    protected function updated(Model $model, array $raw = [], array $record = [])
    {
        $model = $this->updateRole($model, $raw);

        return $model;
    }

    private function parsePassword(array $raw = [])
    {
        if (isset($raw[DBCol::PASSWORD])) {
            $raw[DBCol::PASSWORD] = Hash::make($raw[DBCol::PASSWORD]);
        }

        return $raw;
    }

    public function updateRole(Model $model, array $raw = [])
    {
        if (isset($raw[Role::FK])) {
            $role_id = $raw[Role::FK];

            $model->updateRole($role_id);
        }

        return $model;
    }
}
