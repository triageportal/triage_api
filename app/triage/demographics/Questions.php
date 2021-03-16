<?php

namespace App\triage\demographics;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'demographics_questions';

    protected $fillable = ['category_id', 'eng', 'rus', 'uzb'];
}
