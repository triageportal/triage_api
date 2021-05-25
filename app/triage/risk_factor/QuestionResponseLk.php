<?php

namespace App\triage\risk_factor;

use Illuminate\Database\Eloquent\Model;

class QuestionResponseLk extends Model
{
    protected $table = 'risk_factor_quest_resp_lk';
    protected $fillable = ['question_id', 'response_id'];
}
