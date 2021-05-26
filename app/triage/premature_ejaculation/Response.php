<?php

namespace App\triage\premature_ejaculation;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'premature_ejaculation_response';
    protected $fillable = ['value', 'eng', 'rus', 'uzb'];
}
