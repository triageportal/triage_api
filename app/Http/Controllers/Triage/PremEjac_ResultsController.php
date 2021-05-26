<?php

namespace App\Http\Controllers\Triage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Triage\Calculate_Results\PremEjac_CalculateResult;
use Illuminate\Support\Facades\Auth;

class PremEjac_ResultsController extends Controller
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
        $post_result = $core_results->createRecord($request, 'premature_ejaculation');

        //Capturing user ID.
        $user = Auth::user();
        $created_by = $user -> id;
        //Calculating ans saving the total score.
        $calculate_results = new PremEjac_CalculateResult;
        $calculate_results->calculateResult($request['patient_id'], $created_by, $request['timestamp']);

        return $post_result;

    } catch (exception $e) {

        if(app()->environment() == 'dev'){

            return $e;

       }else{

            return response()->json('error', 500);

       }
    }

    }
}
