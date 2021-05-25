<?php

namespace App\Http\Controllers\Triage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\triage\risk_factor\Results;
use Illuminate\Support\Facades\Auth;
use App\Patient;
use Exception;

class RiskFactor_ResultsController extends Controller
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

            $patient_id = $request['patient_id'];

            $patient_table = new Patient;
            if(!$patient_table::where('id', '=', $patient_id)->first()){

                return response()->json('No such patient', 500);

            }

            //Capturing user ID.
            $user = Auth::user();
            $created_by = $user -> id;
            $current_timestamp = $request['timestamp'];

            $results =  (Array)$request['results'];

            foreach($results as $result){

                $category_id = $result['category_id'];

                $responses = (Array)$result['response'];

                foreach($responses as $response){

                    $question_id = $response['question_id'];

                    $response_id = $response['response_id'];

                    $results_table = new Results;
                    //preg_replace("/[^\d]/", "", *STRING) extracts only numbers from the string.
                    $results_table -> patient_id = preg_replace("/[^\d]/", "", $patient_id);
                    $results_table -> category_id = preg_replace("/[^\d]/", "", $category_id);
                    $results_table -> question_id = preg_replace("/[^\d]/", "", $question_id);
                    $results_table -> response_id = preg_replace("/[^\d]/", "", $response_id);
                    $results_table -> created_by = preg_replace("/[^\d]/", "", $created_by);
                    $results_table -> created_at = $current_timestamp;
                    $results_table -> save();
                }

            }

            return response()->json('success', 200);

        } catch (exception $e) {

            if(app()->environment() == 'dev'){

                return $e;

           }else{

                return response()->json('error', 500);

           }
        }

    }
}
