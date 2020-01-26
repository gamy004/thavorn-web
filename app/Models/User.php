<?php

namespace App\Models;

use Exception;
use App\IOCs\DBCol;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable;

    const FK = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        DBCol::IDENTITY_CARD_ID,
        DBCol::FIRST_NAME,
        DBCol::LAST_NAME,
        DBCol::GENDER,
        DBCol::FACEBOOK,
        DBCol::LINE,
        DBCol::EMAIL,
        DBCol::PHONE_NUMBER,
        DBCol::PASSWORD
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        DBCol::PASSWORD,
        DBCol::REMEMBER_TOKEN
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        DBCol::EMAIL_VERIFIED_AT => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, Role::FK);
    }

    public function pawns()
    {
        return $this->hasMany(Pawn::class, Pawn::USER_FK);
    }

    public function updateRoleByRoleId($role_id)
    {
        try {
            $role = Role::findOrFail($role_id);
            
            $this->updateRole($role);
        } catch (ModelNotFoundException $exception) {
            throw new Exception("Role not found");
        }

        return $this;
    }

    public function updateRole(Role $role)
    {
        $this->role()
            ->associate($role)
            ->save();

        return $this;
    }

    public function assignRoleCustomer()
    {
        $customer_role = Role::customer();

        $this->updateRole($customer_role);

        return $this;
    }

    public function scopeIdCard($query, $id_card)
    {
        return $query->where(
            DBCol::IDENTITY_CARD_ID,
            $id_card
        )->firstOrFail();
    }
}
