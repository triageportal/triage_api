<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vitals extends Model
{
    protected $table = 'vitals';

    protected $fillable = ['patient_id', 'entered_by', 'height_cm', 'weight_kg', 'calculated_bmi', 
                           'temperature_c', 'pulse', 'respiratory_rate', 'bp_systolic', 'bp_diastolic'];

    public function userCreatedBy(){

        //id - the column in Users table.
        //created_by - the column in clinics table.
        return $this->hasOne('App\User', 'id', 'entered_by');

    }
   
}
