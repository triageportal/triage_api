<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $table = 'clinics';

    protected $fillable = ['name', 'status', 'addressLineOne', 'addressLineTwo', 'city', 'zipCode', 'stateOrRegion',

    'country', 'phone', 'email', 'website', 'language', 'contactName', 'contactEmail', 'contactPhone'];

    public function userCreatedBy(){

        //id - the column in Users table.
        //created_by - the column in clinics table.
        return $this->hasOne('App\User', 'id', 'created_by');

    }

    public function userEditedBy(){

        //id - the column in Users table.
        //created_by - the column in clinics table.
        return $this->hasOne('App\User', 'id', 'edited_by');

    }

}
