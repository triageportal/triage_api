<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class AcssController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => []]);       
        
    }

    public function getAcssForm(Request $request){

        $request->validate([

            'language'=>'required|max:3'

        ]);

        $result = [];
        
        $language = $request['language'];
        $categories_result = (array)DB::select('SELECT id, '.$language.' FROM acss_category');

        foreach($categories_result as $item){ 
            
            $item = (array)$item;
            
            $category = [];
            $questions = [];
            $responses = [];

            $category['category'] = $item[$language];

            $question_result = (array)DB::select('SELECT id, '.$language.' FROM acss_questions WHERE category_id = ?', [$item['id']]);           

                foreach($question_result as $question){

                    $question = (array)$question;

                    $loop_questions = [];

                    $loop_questions['question_id'] = $question['id'];

                    $loop_questions['question_text'] = $question[$language];                    

                    $response_lk = (array)DB::select('SELECT response_id FROM acss_quest_resp_lk WHERE question_id = '.$question['id']);

                    foreach($response_lk as $lk){
                        
                        $lk = (array)$lk;

                        $response_result = (array)DB::select('SELECT value, '.$language.' FROM acss_response WHERE id = '.$lk['response_id']);

                        foreach($response_result as $response){

                            $response = (array)$response;

                            $response_loop = [];

                            $response_loop['response_text'] = $response[$language];
                            $response_loop['value'] = $response['value'];

                            array_push($responses, $response_loop); 

                        }

                    }
                    $loop_questions['responses'] = $responses; 
                    $responses = [];                   
                    array_push($questions, $loop_questions);

                }
            
            $category['questions']=$questions;
            array_push($result, $category);
        }
        

        return response()->json($result, 200);

       

    }
}
