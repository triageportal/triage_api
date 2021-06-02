<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TriageListObj extends Controller
{
    
    public $triages = [

        'traige_id' => null,
        'triage' => '',
        'title' => '',
        'description' => ''
    
    ];

    public $triage_full_list = [

        'triage_id'=>'',
        'title'=>'',
        'description'=>''

    ];

}
