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
    public function calculateResult($patient_id, $created_by){

        $last_record = Results::where('patient_id', '=', $patient_id)->orderBy('created_at','DESC')->first();
        $patient_results = Results::where('patient_id', '=', $patient_id)->where('created_at', '=', $last_record['created_at'])->get()->toArray();

        $total_point = 0;

        foreach($patient_results as $result){

            $response_id = $result['response_id'];
            $response_details = Response::where('id', '=', $response_id)->first();
            $response_value = (int)$response_details['value'];
            $total_point += $response_value;

        }

        $this->saveCalculatedResut($total_point, $created_by, $patient_id, $last_record['created_at']);

    }

    public function saveCalculatedResut($total_point, $created_by, $patient_id, $timestamp){

        $calc_result = new CalculatedResult;
        $calc_result['patient_id'] = $patient_id;
        $calc_result['created_by'] = $created_by;
        $calc_result['total_points'] = $total_point;
        $calc_result['created_at'] = $timestamp;
        $calc_result->save();

    }

    public function lastCalculatedResult(Request $request){

        $request->validate([

            'patient_id'=>'required|integer',
            'language'=>'required'

        ]);

        $patient_id = $request['patient_id'];

        try {
            //Getting the last calculated result (total).
            $last_calc_result = CalculatedResult::where('patient_id', '=', $patient_id)->orderBy('created_at','DESC')->first();

            if($last_calc_result != null){

                //Getting the created_by user details.
                $created_by = User::where('id', '=', $last_calc_result['created_by'])->first();

                //Getting the patient details.
                $patient = Patient::where('id', '=', $patient_id)->first();

                //Getting clinic details.
                $clinic = Clinic::where('id', '=', $patient['clinic_id'])->first();

                $result = [

                    'patient_name' => $patient['first_name'].', '.$patient['last_name'],
                    'clinic_name' => $clinic['name'],
                    'created_by' => $created_by['first_name'].', '.$created_by['last_name'],
                    'total_score' => $last_calc_result['total_points'],
                    'diagnosis' => $this->pe_diagnosis($last_calc_result['total_points'], $request),
                    'test_date' => $last_calc_result['created_at']

                ];

                return response()->json($result, 200);

            }else{

                return response()->json('No result found.', 500);

            }


        } catch (Exception $e) {
            if(app()->environment() == 'dev'){

                return $e;

           }else{

                return response()->json('error', 500);

           }
        }


    }

    private function pe_diagnosis($total_points, Request $request){

        if((int)$total_points >= 12){

            switch ($request['language']) {
                case 'eng':
                    return 'Possible PE (Premature Ejaculation) detected.';
                    break;
                case 'rus':
                    return 'Обнаружена возможная ПЭ (преждевременная эякуляция).';
                    break;
            }

        }else{

            switch ($request['language']) {
                case 'eng':
                    return 'PE (Premature Ejaculation) not detected.';
                    break;
                case 'rus':
                    return 'ПE (преждевременная эякуляция) не обнаружена.';
                    break;

            }

        }

    }
}
