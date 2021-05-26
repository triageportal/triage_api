<?php

namespace App\triage\premature_ejaculation;

use Illuminate\Database\Eloquent\Model;

class CalculatedResult extends Model
{
    protected $table = 'premature_ejaculation_calculated_result';
    protected $fillable=['patient_id', 'created_by', 'total_points', 'created_at'];

}
