<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TriagesDescription extends Model
{
    protected $table = 'triages_description';

    protected $fillable = ['triage_id', 'eng', 'rus', 'uzb'];
}
