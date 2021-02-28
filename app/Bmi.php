<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bmi extends Model
{
    protected $table = 'bmi';

    protected $fillable = ['patient_id', 'entered_by', 'edited_by', 'height_cm', 'weight_kg', 'calculated_bmi'];

    public function userCreatedBy(){

        //id - the column in Users table.
        //created_by - the column in clinics table.
        return $this->hasOne('App\User', 'id', 'entered_by');

    }

    public function userEditedBy(){

        //id - the column in Users table.
        //created_by - the column in clinics table.
        return $this->hasOne('App\User', 'id', 'edited_by');

    }
}
