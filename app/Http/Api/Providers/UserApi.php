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

    public function update(Model $user, array $raw)
    {
        try {
            DB::beginTransaction();

            $record = [];
            $record = $this->parseGeneralFields($record, $raw);
            $record = $this->parsePassword($record, $raw);
            $user->update($record);

            DB::commit();

            return $this->find($user->id);
        } catch (Exception $exception) {
            DB::rollback();
            Log::error($exception);
            throw $exception;
        }
    }

    public function restore($id)
    {
        try {
            DB::beginTransaction();

            $restore = $this->originalModel
                ->withTrashed()
                ->where(DBCol::ID, $id)
                ->restore();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

            Log::error($exception);

            throw $exception;
        }
    }

    private function parsePassword(array $raw = [])
    {
        if (isset($raw[DBCol::PASSWORD])) {
            $raw[DBCol::PASSWORD] = Hash::make($raw[DBCol::PASSWORD]);
        }

        return $raw;
    }
}
