<?php

namespace App\triage\demographics;

use Illuminate\Database\Eloquent\Model;

class QuestionResponseLk extends Model
{
    protected $table = 'demographics_question_response_lk';
    protected $fillable = ['question_id', 'response_id'];
}
