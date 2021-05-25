<?php

namespace App\triage\risk_factor;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'risk_factor_category';

    protected $fillable=['eng', 'rus', 'uzb'];
}
