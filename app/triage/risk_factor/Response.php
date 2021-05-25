<?php

namespace App\triage\risk_factor;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'risk_factor_response';
    protected $fillable = ['value', 'eng', 'rus', 'uzb'];
}
