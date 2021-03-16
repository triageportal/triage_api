<?php

namespace App\triage\demographics;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'demographics_response';
    protected $fillable = ['value', 'eng', 'rus', 'uzb'];
}
