<?php

namespace App\Http\Controllers\Triage;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Triage\Core_ResultsController;
use Exception;


class ACSS_ResultsController extends Controller
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
            $result = $core_results->createRecord($request, 'acss');
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
