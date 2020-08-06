<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $table = 'clinics';

    protected $fillable = ['name', 'status', 'addressLineOne', 'addressLineTwo', 'city', 'zipCode', 'stateOrRegion',

    'country', 'phone', 'email', 'website', 'language', 'contactName', 'contactEmail', 'contactPhone'];



}
