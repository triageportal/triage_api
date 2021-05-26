<?php

namespace App\Http\Controllers\Triage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

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
        $result = $core_results->createRecord($request, 'premature_ejaculation');
        return $result;

    } catch (exception $e) {

        if(app()->environment() == 'dev'){

            return $e;

       }else{

            return response()->json('error', 500);

       }
    }

    }
}