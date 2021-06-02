<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClinicTirageLink extends Model
{
    protected $table = 'clinic_triage_lk';

    protected $fillable = ['clicni_id', 'triage_id', 'created_by'];
}
