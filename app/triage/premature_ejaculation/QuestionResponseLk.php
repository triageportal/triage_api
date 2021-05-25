<?php

namespace App\triage\premature_ejaculation;

use Illuminate\Database\Eloquent\Model;

class QuestionResponseLk extends Model
{
    protected $table = 'premature_ejaculation_quest_resp_lk';
    protected $fillable = ['question_id', 'response_id'];
}
