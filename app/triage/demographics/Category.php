<?php

namespace App\triage\demographics;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'demographics_category';

    protected $fillable=['eng', 'rus', 'uzb'];
}
