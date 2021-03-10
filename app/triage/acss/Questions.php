<?php

namespace App\triage\acss;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'acss_questions';

    protected $fillable = ['category_id', 'eng', 'rus', 'uzb'];
}
