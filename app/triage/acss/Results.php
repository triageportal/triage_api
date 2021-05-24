<?php

namespace App\triage\acss;

use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    protected $table = 'acss_results';
    protected $fillable = ['patient_id', 'category_id', 'question_id', 'response_id', 'created_by'];
}
