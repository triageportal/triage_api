<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClinicTirageLink;
use Illuminate\Support\Facades\Auth;
use Exception;

class ClinicTriageLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => []]);       
        
    }

    public function linkTriageToClinic(Request $request){

        $request -> validate([

            //triage_id must be an array of integers.
            'clinic_id' => 'required',
            'triage_id' => 'required'
            
        ]);

        try {
            //Capturing user details.
        $user = Auth::user();  

        $triage_arr = (array)$request['triage_id'];

        foreach($triage_arr as $triage_id){

            $clinicTiageLk = new ClinicTirageLink;

            $clinicTiageLk['clinic_id'] = $request['clinic_id'];
            $clinicTiageLk['triage_id'] = $triage_id;
            $clinicTiageLk['created_by'] = $user['id'];
            $clinicTiageLk->save();

        }

        return response()->json('success', 200);

        } catch (Exception $e) {
            if(app()->environment() == 'dev'){

                return $e;

            }else{

                return response()->json('error', 500);

            }
        }

    }
        

}
