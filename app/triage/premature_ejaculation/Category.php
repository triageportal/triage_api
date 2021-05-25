<?php

namespace App\triage\premature_ejaculation;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'premature_ejaculation_category';

    protected $fillable=['eng', 'rus', 'uzb'];
}
