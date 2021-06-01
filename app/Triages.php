<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Triages extends Model
{
    protected $table = 'triages';

    protected $fillable = ['triage_id', 'triage', 'eng', 'rus', 'uzb'];
}
