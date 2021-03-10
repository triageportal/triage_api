<?php

namespace App\triage\acss;

use Illuminate\Database\Eloquent\Model;

class QuestionResponseLk extends Model
{
    protected $table = 'acss_quest_resp_lk';
    protected $fillable = ['question_id', 'response_id'];
}
