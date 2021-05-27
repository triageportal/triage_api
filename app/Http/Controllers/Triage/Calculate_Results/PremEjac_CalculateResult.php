<?php

namespace App\Http\Controllers\Triage\Calculate_Results;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\triage\premature_ejaculation\Results;
use App\triage\premature_ejaculation\Response;
use App\triage\premature_ejaculation\CalculatedResult;
use App\User;
use App\Patient;
use App\Clinic;
use Exception;

class PremEjac_CalculateResult extends Controller
{
    public function calculateResult($patient_id, $created_by, $timestamp){

        $patient_results = Results::where('patient_id', '=', $patient_id)->where('created_at', '=', $timestamp)->get()->toArray();

        $total_point = 0;

        foreach($patient_results as $result){

            $response_id = $result['response_id'];
            $response_details = Response::where('id', '=', $response_id)->first();
            $response_value = (int)$response_details['value'];
            $total_point += $response_value;

        }

        $this->saveCalculatedResut($total_point, $created_by, $patient_id, $timestamp);

    }

    public function saveCalculatedResut($total_point, $created_by, $patient_id, $timestamp){

        $calc_result = new CalculatedResult;
        $calc_result['patient_id'] = $patient_id;
        $calc_result['created_by'] = $created_by;
        $calc_result['total_points'] = $total_point;
        $calc_result['created_at'] = $timestamp;
        $calc_result->save();

    }

    
}
