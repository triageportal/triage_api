<?php

namespace App\triage\risk_factor;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'risk_factor_questions';

    protected $fillable = ['category_id', 'eng', 'rus', 'uzb'];
}
