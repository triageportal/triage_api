<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Controllers\Objects\QuestionnaireObj;
use Illuminate\Http\Request;
use App\Http\Helper\HelperClass;

class FormsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => []]);

    }

    public function getForm(Request $request){

        $request->validate([

            'language'=>'required|max:3',
            'form' => 'required'

        ]);

        $help = new HelperClass;
        $request =$help -> sanitize($request->all());

           try{

            $query = 'SELECT cat.?language AS category,
                    cat.id AS category_id,
                    cat.eng AS cat_eng,
                    quest.id AS question_id,
                    quest.?language AS question_text,
                    resp.id AS response_id,
                    resp.?language AS response_text,
                    resp.value AS response_value

                    FROM ?table_category AS cat

                    INNER JOIN ?table_questions AS quest ON cat.id = quest.category_id
                    INNER JOIN ?table_quest_resp_lk  AS lk ON quest.id = lk.question_id
                    INNER JOIN ?table_response AS resp ON lk.response_id = resp.id';

            switch ($request['form']) {
                case "acss":

                    $query = str_replace('?table', 'acss', $query);
                    $query = str_replace('?language', $request['language'], $query);

                  break;

                case "demographics":

                    $query = str_replace('?table', 'demographics', $query);
                    $query = str_replace('?language', $request['language'], $query);

                    break;

                case "risk_factor":

                    $query = str_replace('?table', 'risk_factor', $query);
                    $query = str_replace('?language', $request['language'], $query);

                    break;

                case "premature_ejaculation":

                    $query = str_replace('?table', 'premature_ejaculation', $query);
                    $query = str_replace('?language', $request['language'], $query);

                    break;

                default:
                return response()->json('unable to find requested diagnostics form.', 500);
              }

            $db_result = (array)DB::select($query);

            $cats = [];

            $duplicate_cats = [];

            foreach($db_result as $result){

                $result = (array)$result;

                if(!in_array($result['category'], $duplicate_cats)){

                    array_push($duplicate_cats, $result['category']);
                    $template = new QuestionnaireObj;
                    $cat_template = $template->category;
                    $cat_template['category'] = $result['category'];
                    $key = strtolower(str_replace(' ', '_', $result['cat_eng']));
                    $cat_template['category_id'] = $result['category_id'];
                    $cats[$key] = $cat_template;

                }

            }

            foreach($cats as $key => $this_cat){

                $category = $this_cat;

                $duplicate_quest = [];

                $questions = [];

                foreach($db_result as $result){

                    $result = (array)$result;

                    if($result['category'] == $category['category'] && !in_array($result['question_text'], $duplicate_quest)){

                        array_push($duplicate_quest, $result['question_text']);
                        $template = new QuestionnaireObj;
                        $quest_template = $template->questions;
                        $quest_template['question_text'] = $result['question_text'];
                        $quest_template['question_id'] = $result['question_id'];
                        array_push($questions, $quest_template);

                    }

                }

                $cats[$key]['questions'] = $questions;

            }

            foreach($cats as $key => $this_cat){

                $questions = $cats[$key]['questions'];

                for($j=0; $j<sizeof($questions); $j++){

                    $question_text = $questions[$j]['question_text'];

                    foreach($db_result as $result){

                        $result = (array)$result;

                        if($question_text == $result['question_text']){

                            $template = new QuestionnaireObj;
                            $resp_template = $template->responses;
                            $resp_template['response_id'] = $result['response_id'];
                            $resp_template['response_text'] = $result['response_text'];
                            $resp_template['response_value'] = $result['response_value'];
                            array_push($questions[$j]['responses'], $resp_template);

                        }

                    }

                }

                $cats[$key]['questions'] = $questions;
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
