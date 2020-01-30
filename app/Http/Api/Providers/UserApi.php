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
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $model = $this->updateRoleByRoleId($model, $raw);

        return $model;
    }

    public function beforeUpdate(Model $model, array $raw = [])
    {
        $raw = $this->parsePassword($raw);

        return [$model, $raw];
    }

    protected function updated(Model $model, array $raw = [], array $record = [])
    {
        $model = $this->updateRoleByRoleId($model, $raw);

        return $model;
    }

    private function parsePassword(array $raw = [])
    {
        if (isset($raw[DBCol::PASSWORD])) {
            $raw[DBCol::PASSWORD] = Hash::make($raw[DBCol::PASSWORD]);
        }

        return $raw;
    }

    public function updateRoleByRoleId(Model $model, array $raw = [])
    {
        if (isset($raw[Role::FK])) {
            $role_id = $raw[Role::FK];

            $model->updateRoleByRoleId($role_id);
        }

        return $model;
    }

    public function createOrUpdateCustomer(array $raw = [])
    {
        try {
            $user = User::idCard($raw[DBCol::IDENTITY_CARD_ID]);

            $user = $this->update($user, $raw)->first();
        } catch (ModelNotFoundException $exception) {
            // Set identity card as a password
            $raw[DBCol::PASSWORD] = $raw[DBCol::IDENTITY_CARD_ID];
            
            // Create user
            $user = $this->store($raw)->first();

            // Assign this user to customer role
            $user->assignRoleCustomer();
        }

        return $user;
    }
}
