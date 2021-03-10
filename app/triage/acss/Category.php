<?php

namespace App\triage\acss;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'acss_category';

    protected $fillable=['eng', 'rus', 'uzb'];
}
