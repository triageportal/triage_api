<?php

namespace App\Http\Controllers\Triage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Triage\Calculate_Results\PremEjac_CalculateResult;
use Illuminate\Support\Facades\Auth;
use App\triage\premature_ejaculation\CalculatedResult;
use App\User;
use App\Patient;
use App\Clinic;
use Carbon\Carbon;


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
        //Calculating and saving the total score.
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

    public function lastCalculatedResult(Request $request){

        $request->validate([

            'patient_id'=>'required|integer',
            'language'=>'required'

        ]);

        $patient_id = $request['patient_id'];

        try {

            //Getting the last calculated result (total).
            $last_calc_result = null;

            //If test date is pased in, the result for that date is returned. Else, the last test result is returned.
            if(isset($request['test_date'])){

                $last_calc_result = CalculatedResult::where('patient_id', '=', $patient_id)->where('created_at', $request['test_date'])->first();

            }else{

                $last_calc_result = CalculatedResult::where('patient_id', '=', $patient_id)->orderBy('created_at','DESC')->first();

            }

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
                    'diagnosis' => $this->pe_diagnosis($last_calc_result['total_points'], $request),
                    'test_date' => $this->reformatDate($request, $last_calc_result['created_at'])

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

    private function reformatDate($request, $date){

        //Reformatting the test date.
        $createdAt = Carbon::parse($date);

        switch ($request['language']) {
            case 'eng':

                $createdAt = $createdAt->format('m/d/Y H:i:s');
                
                return $createdAt;

                break;
            case 'rus':

                $createdAt = $createdAt->format('d/m/Y H:i:s');

                return $createdAt;

                break;
        }

    }

    private function pe_diagnosis($total_points, Request $request){

        if((int)$total_points >= 12){

            switch ($request['language']) {
                case 'eng':
                    return ['Total points: '.strval($total_points), 'Possible PE (Premature Ejaculation) detected.'];
                    break;
                case 'rus':
                    return ['Общее количество очков: '.strval($total_points), 'Обнаружена возможная ПЭ (преждевременная эякуляция).'];
                    break;
            }

        }else{

            switch ($request['language']) {
                case 'eng':
                    return ['Total points: '.strval($total_points), 'PE (Premature Ejaculation) not detected.'];
                    break;
                case 'rus':
                    return ['Общее количество очков: '.strval($total_points), 'ПE (преждевременная эякуляция) не обнаружена.'];
                    break;

            }

        }

    }
}
