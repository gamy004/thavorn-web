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

    public function index() {

        $this->setCustomModel(
            $this->queryIndex()
        );

        return parent::index();
    }

    private function queryIndex()
    {
        $base_table = $this->getBaseBuilderTable();

        $sub_query__fullname_name = 'sub_query__fullname';
        $sub_query__fullname = $this->getOriginalModel()
            ->select([
                DB::raw(
                    sprintf("`%s`.id as user_id", $base_table)
                ),
                DB::raw(
                    sprintf(
                        "CONCAT(`%s`.%s, ' ',`%s`.%s) as %s",
                        $base_table,
                        DBCol::FIRST_NAME,
                        $base_table,
                        DBCol::LAST_NAME,
                        DBCol::FULL_NAME
                    )
                )
            ]);
        
        $index_query = $this->getOriginalModel()
            ->joinSub(
                $sub_query__fullname,
                $sub_query__fullname_name,
                function ($join) use ($base_table, $sub_query__fullname_name) {
                    $join->on(
                        sprintf("%s.id", $base_table),
                        '=',
                        sprintf("%s.user_id", $sub_query__fullname_name)
                    );
                }
            );

        return $index_query;
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
            $user = User::fullname($raw[DBCol::FIRST_NAME], $raw[DBCol::LAST_NAME]);

            $user = $this->update($user, $raw)->first();
        } catch (ModelNotFoundException $exception) {
            // Set identity card as a password
            $raw[DBCol::PASSWORD] = '1234';
            
            // Create user
            $user = $this->store($raw)->first();

            // Assign this user to customer role
            $user->assignRoleCustomer();
        }

        return $user;
    }
}
