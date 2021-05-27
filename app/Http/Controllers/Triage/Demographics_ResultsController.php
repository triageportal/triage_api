<?php

namespace App\Http\Controllers\Triage;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\triage\demographics\Results;
use App\Http\Controllers\Objects\DemographicsExistingValueObj;

class Demographics_ResultsController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => []]);

    }

    public function createRecord(Request $request){

    $request->validate([

        'patient_id'=>'required|integer',
        'timestamp'=>'required'

    ]);

    try {

        $core_results = new Core_ResultsController;
        $result = $core_results->createRecord($request, 'demographics');
        return $result;

    } catch (exception $e) {

        if(app()->environment() == 'dev'){

            return $e;

       }else{

            return response()->json('error', 500);

       }
    }

    }

    public function getLastRecord(Request $request){

        $request->validate([

            'patient_id'=>'required|integer'
                
        ]);

        try {
            $last_date_record = Results::where('patient_id', '=', $request['patient_id'])->orderBy('created_at','DESC')->first();
            $last_record_list = Results::where('patient_id', '=', $request['patient_id'])->where('created_at', '=', $last_date_record['created_at'])->get()->toArray();
            $list_of_categories =  Results::where('patient_id', '=', $request['patient_id'])->where('created_at', '=', $last_date_record['created_at'])->select('category_id')->distinct()->get()->toArray();
    
            $result = [];
    
            foreach($list_of_categories as $category){
    
                $category_obj = new DemographicsExistingValueObj;
    
                $category_obj = $category_obj->category;
    
                $category_obj['category_id'] = $category['category_id'];
    
                foreach($last_record_list as $record){
    
                    if($record['category_id'] == $category_obj['category_id']){
    
                        $result_obj = new DemographicsExistingValueObj;
    
                        $result_obj = $result_obj->results;
    
                        $result_obj['question_id'] = $record['question_id'];
    
                        $result_obj['response_id'] = $record['response_id'];
    
                        array_push($category_obj['results'],  $result_obj);
    
                    }
    
                }
    
                array_push($result,  $category_obj);
    
            }   
    
            return response()->json($result, 200);

        } catch (Exception $e) {

            if(app()->environment() == 'dev'){

                return $e;

            }else{

                return response()->json('error', 500);

            }
        }


    }

}
