<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper\HelperClass;
use Exception;
use App\Bmi;
use App\User;
use App\Clinic;
use Carbon\Carbon;

class BmiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => []]);       
        
    }

    public function postBmi(Request $request){

        $request -> validate([

            'patient_id' => 'required|integer',            
            //height, weight must be passed in as double (i.e. 120.00)
            'height' => 'required|regex:/^[0-9]+(\.[0-9][0-9])/',
            'weight' => 'required|regex:/^[0-9]+(\.[0-9][0-9])/',
            //if more units of measuremts are added, the regex below must be updated.
            'height_unit' => 'required',
            'weight_unit' => 'required'

        ]);

        try{

            $existing_record = Bmi::firstWhere('patient_id', $request['patient_id']);

            if($existing_record != null){

                unset($existing_record['entered_by']);
                unset($existing_record['edited_by']);
          
                $existing_record['status'] = 'existing record';
                return response()->json($existing_record, 200);

            }

            $help = new HelperClass;
            $request =$help -> sanitize($request->all());

            $final_weight_kg = null;
            $final_height_cm = null;    

            //if in KG, no conversion needed. Value goes to the DB as DOUBLE.
            if($request['weight_unit'] == 'kg'){

                $final_weight_kg = (double)$request['weight'];

            //If in LB, I convert the value to KG, then write to DB.    
            }else if($request['weight_unit'] == 'lb'){

                $final_weight_kg = $help -> lbToKg($request['weight']);
            }

            //if in CM, no conversion needed. Value goes to the DB as DOUBLE.
            if($request['height_unit'] == 'cm'){

                $final_height_cm = (double)$request['height'];

            //If in INCH, I convert the value to CM, then write to DB.
            }else if($request['height_unit'] == 'inch'){

                $final_height_cm = $help -> inchToCm($request['height']);
            }

            //Calculating BMI here.
            $calc_bmi = $help -> calculateBmi((double)$final_height_cm, (double) $final_weight_kg);

            //Gets the user object, so that I can get user ID from here.
            $user = Auth::user();
            $bmi = new Bmi();


            //updating the DB.
            $bmi -> patient_id = $request['patient_id'];
            $bmi -> entered_by = $user -> id;
            $bmi -> edited_by = NULL;
            $bmi -> height_cm =  (double)$final_height_cm;
            $bmi -> weight_kg = (double) $final_weight_kg;
            $bmi -> calculated_bmi = $calc_bmi;
            $bmi -> save();


            $bmi_result = [];

            $bmi_result['weight'] = $request['weight'];
            $bmi_result['height'] = $request['height'];
            $bmi_result['bmi'] = $calc_bmi;

            return response()->json($bmi_result, 200);    

        } catch (exception $e) {

            //return response()->json('error', 500);
            return $e;

        }

        

    }



}
