<?php

namespace App\triage\premature_ejaculation;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'premature_ejaculation_questions';
    protected $fillable = ['category_id', 'eng', 'rus', 'uzb'];
}
