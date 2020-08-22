<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements JWTSubject
{

protected $table = 'users';


    use Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', "position", "access_type", "registration_hash", "clinic_id", "status", "created_by", "last_edited_by"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'registration_hash'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function clinic(){

        //id - the column name (in clinic table) that is in another (child) table.
        //clinic_id - column name (in user table) that is the current (this - parent) table.
        return $this->hasOne('App\Clinic', 'id', 'clinic_id');

    }

}
