<?php

namespace App\Http\Controllers\Vitals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper\HelperClass;
use Exception;
use App\Vitals;
use App\User;
use App\Clinic;
use Carbon\Carbon;

class VitalsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => []]);       
        
    }

    public function calcBmi(Request $request){

        $request -> validate([

            'patient_id' => 'required|integer',            
            //height, weight must be passed in as double (i.e. 120.00)
            'height' => 'required|regex:/^[0-9]+(\.[0-9][0-9])/',
            'weight' => 'required|regex:/^[0-9]+(\.[0-9][0-9])/',
            'height_unit' => 'required',
            'weight_unit' => 'required'

        ]);

        try{

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

            $bmi_result = []; 
            $bmi_result['height_cm'] =  $final_height_cm;
            $bmi_result['weight_kg'] =  $final_weight_kg;
            $bmi_result['bmi'] = $calc_bmi;

            return response()->json($bmi_result, 200);    

        } catch (exception $e) {

            //return response()->json('error', 500);
            return $e;

        }        

    }

    public function postVitals(Request $request){

    $request -> validate([

        'patient_id' => 'required|integer',
        'height_cm' => 'required_with:weight_kg, bmi|regex:/^[0-9]+(\.[0-9][0-9])/',
        'weight_kg' => 'required_with:height_cm, bmi|regex:/^[0-9]+(\.[0-9][0-9])/',
        'bmi' => 'required_with:weight_kg, height_cm|regex:/^[0-9]+(\.[0-9][0-9])/',
        'temp' => 'required_with:temp_unit|regex:/^[0-9]+(\.[0-9])/',
        'temp_unit' => 'required_with:temp|in:c,f',
        'pulse' => 'nullable|integer|max:500',
        'resp_rate' => 'nullable|integer|max:200',
        'bp_systolic' => 'required_with:bp_diastolic|integer|max:400',        
        'bp_diastolic' => 'required_with:bp_systolic|integer|max:400'

    ]);


    $help = new HelperClass();
    //Converting from F to C.
    $final_temp_c = null;
    
    if(strtolower($request['temp_unit']) == 'f'){

        $final_temp_c = $help -> farToCel($request['temp']);

    }else if(strtolower($request['temp_unit']) == 'c'){

        $final_temp_c = (double)number_format($request['temp'], 1);

    }

    //Capturing user ID.
    $user = Auth::user();  
    $created_by = $user -> id;

    $vitals = new Vitals();

    }
}
