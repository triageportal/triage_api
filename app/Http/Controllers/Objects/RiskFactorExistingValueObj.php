<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiskFactorExistingValueObj extends Controller
{
    public $category = [

        'category_id' => '',
        'results' => []
        
    ];

    public $results = [

        'question_id' => "",
        'response_id' => ''
    ];
}
