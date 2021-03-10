<?php

namespace App\triage\acss;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'acss_response';
    protected $fillable = ['value', 'eng', 'rus', 'uzb'];
}
