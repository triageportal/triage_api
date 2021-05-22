<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionnaireObj extends Controller
{
    public $category = [

        'category' => "",
        'category_id' => '',
        'questions' => []
    ];

    public $questions = [

        'question_id' => '',
        'question_text' => '',
        'responses' => []
    ];

    public $responses = [

        'response_id' => '',
        'response_text' => '',
        'response_value' => ''
    ];

}
