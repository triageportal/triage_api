<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Controllers\Objects\AcssObject;
use App\triage\acss\Category;
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

           try{

            $query = 'SELECT cat.? AS category, quest.id AS question_id, quest.? AS question_text, 
            resp.id AS response_id, resp.? AS response_text, resp.value AS response_value FROM acss_category
             AS cat INNER JOIN acss_questions AS quest ON cat.id = quest.category_id INNER JOIN acss_quest_resp_lk 
             AS lk ON quest.id = lk.question_id INNER JOIN acss_response AS resp ON lk.response_id = resp.id';

            $query = str_replace('?', $request['language'], $query);

            $db_result = (array)DB::select($query);

            $cats = [];            

            $duplicate_cats = [];

            foreach($db_result as $result){

                $result = (array)$result;               

                if(!in_array($result['category'], $duplicate_cats)){

                    array_push($duplicate_cats, $result['category']);
                    $template = new AcssObject;
                    $cat_template = $template->category;
                    $cat_template['category'] = $result['category'];                    
                    array_push($cats,  $cat_template);

                }

            }

            for($i=0; $i<sizeof($cats); $i++){

                $category = $cats[$i];

                $duplicate_quest = [];

                $questions = [];

                foreach($db_result as $result){

                    $result = (array)$result; 

                    if($result['category'] == $category['category'] && !in_array($result['question_text'], $duplicate_quest)){

                        array_push($duplicate_quest, $result['question_text']);
                        $template = new AcssObject;
                        $quest_template = $template->questions;
                        $quest_template['question_text'] = $result['question_text'];
                        $quest_template['question_id'] = $result['question_id'];
                        array_push($questions, $quest_template);

                    }

                }

                $cats[$i]['questions'] = $questions;     

            }

            for($i=0; $i<sizeof($cats); $i++){

                $questions = $cats[$i]['questions'];

                for($j=0; $j<sizeof($questions); $j++){

                    $question_text = $questions[$j]['question_text'];             
                   
                    foreach($db_result as $result){

                        $result = (array)$result; 

                        if($question_text == $result['question_text']){

                            $template = new AcssObject;
                            $resp_template = $template->responses;
                            $resp_template['response_id'] = $result['response_id'];
                            $resp_template['response_text'] = $result['response_text'];
                            $resp_template['response_value'] = $result['response_value'];
                            array_push($questions[$j]['responses'], $resp_template);   
                            
                        }

                    }

                }

                $cats[$i]['questions'] = $questions;
            }
            
            return response()->json($cats, 200);

           }catch(Exception $e){
            if(app()->environment() == 'dev'){

                return $e;

           }else{

                return response()->json('error', 500);

           }

           }
            
            

    }
}
