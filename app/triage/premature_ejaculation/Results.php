<?php

namespace App\triage\premature_ejaculation;

use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    protected $table = 'premature_ejaculation_results';
    protected $fillable = ['patient_id', 'category_id', 'question_id', 'response_id', 'created_by', 'created_at', 'updated_at'];

}
