<?php

namespace App\triage\demographics;

use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    protected $table = 'demographics_results';
    protected $fillable = ['patient_id', 'category_id', 'question_id', 'response_id', 'created_by', 'created_at', 'updated_at'];

}
