<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [

        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'email',
        'created_by',
        'updated_by'

    ];


    public function createdBy(){

        return $this->hasOne('App\User', 'id', 'created_by');

    }

    public function updatedBy(){

        return $this->hasOne('App\User', 'id', 'updated_by');

    }

}
