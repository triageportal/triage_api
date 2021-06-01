<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TriagesDescription;
use App\Triages;
use App\ClinicTirageLink;
use App\Http\Controllers\Objects\TriageListObj;
use Illuminate\Support\Facades\Auth;
use Exception;

class TriagesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => []]);

    }

    public function getTriageList(Request $request){

        $request -> validate([

            'language'=>'required'
    
        ]);


        try {
            //Capturing user details.
            $user = Auth::user();  
            $clinic_id = $user['clinic_id'];     
            
            $triage_list = ClinicTirageLink::where('clinic_id', '=', $clinic_id)->get()->toArray();

            $triage_result = [];

            foreach($triage_list as $triage){

                $triage_obj = new TriageListObj;

                $result = $triage_obj->triages;

                $triage_details = Triages::where('triage_id', '=', $triage['triage_id'])->first()->toArray();

                $triage_description = TriagesDescription::where('triage_id', '=', $triage['triage_id'])->first()->toArray();

                $result['traige_id'] = $triage_details['triage_id'];
                $result['triage'] = $triage_details['triage'];
                $result['triage'] = $triage_details['triage'];
                $result['title'] = $triage_details[$request['language']];
                $result['description'] = $triage_description[$request['language']];

                array_push($triage_result, $result);

            }

            return response()->json($triage_result, 200);
            
        } catch (Exception $e) {
            if(app()->environment() == 'dev'){

                return $e;

            }else{

                return response()->json('error', 500);

            }
        }

    }
    
}
