<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\User;
use App\Http\Helper\HelperClass;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmailController;
use Exception;



class PatientController extends Controller
{

    public function createPatient(Request $request){

        $request -> validate([

            'first_name'=>'required',
            'last_name'=>'required',
            'year'=>'required',
            'month'=>'required',
            'date'=>'required',
            'gender'=>'required',
            'email'=>'required|email'

        ]);

        $user = Auth::user();

        if($user->clinic_id == 0){

            return response()->json('Cannot create patient with clinic_id = 0', 500);

        }


        $dob_Month = $request['month'];

        $dob_Date = $request['date'];

        $dob_Year = $request['year'];

        $date = strtotime($dob_Month."/".$dob_Date."/". $dob_Year);

        $request['date_of_birth'] = date('Y-m-d H:i:s', $date);

        try {

            $help = new HelperClass();

            $request = $help->sanitize($request->all());

            $patient = new Patient();

            $users = new User();

            $patientCheck = $patient::where('email', $request['email'])->where('clinic_id', $user['clinic_id'])->get();

            if(isset($patientCheck)){

                foreach($patientCheck as $item){

                    if($user['clinic_id'] == $item['clinic_id']){

                        //Replacing created_by and updated_by ids with actual user names.
                        $createdByUser = $users::where('id', $item['created_by'])->first();

                        $item['created_by'] = $createdByUser['first_name'].' '.$createdByUser['last_name'];

                        if($item['updated_by'] != null){

                            $updatedByUser = $users::where('id', $item['updated_by'])->first();

                            $item['updated_by'] = $updatedByUser['first_name'].' '.$updatedByUser['last_name'];

                        } else{

                            $item['updated_by'] = 'Not available';

                        }

                        $item['clinic_name'] = $item->assignedClinic->name;

                        //Unsetting eloquent relationships.
                        unset($item->assignedClinic);

                        unset($item->createdBy);

                        unset($item->updatedBy);

                        $patientExists['result'] = 'exists';

                        $patientExists['patient'] = $item;

                        return response()->json($patientExists, 200);

                    }

                }

            }

            $patient->first_name = $request['first_name'];
            $patient->last_name = $request['last_name'];
            $patient->date_of_birth = $request['date_of_birth'];
            $patient->gender = $request['gender'];
            $patient->email = $request['email'];
            $patient->created_by = $user['id'];
            $patient->clinic_id = $user['clinic_id'];

            $patient->save();

            $sendEmail = new EmailController();

            $newPatient = Patient::where('email', $request['email'])->where('created_by', $user['id'])->first();

            $sendEmail->sendPatientRegistrationEmail($newPatient['email'], $newPatient, 'ENG');

            //Replacing created_by and updated_by ids with actua;l user names.
            $createdByUser = $users::where('id', $newPatient['created_by'])->first();

            $newPatient['created_by'] = $createdByUser['first_name'].' '.$createdByUser['last_name'];

            if($newPatient['updated_by'] != null){

                $updatedByUser = $users::where('id', $newPatient['updated_by'])->first();

                $newPatient['updated_by'] = $updatedByUser['first_name'].' '.$updatedByUser['last_name'];

            } else{

                $newPatient['updated_by'] = 'Not available';

            }

            $newPatient['clinic_name'] = $newPatient->assignedClinic->name;

            //Unsetting eloquent relationships.
            unset($newPatient->assignedClinic);

            unset($newPatient->createdBy);

            unset($newPatient->updatedBy);

            $patientSuccess['result'] = 'success';

            $patientSuccess['patient'] = $newPatient;

            return response()->json($patientSuccess, 200);

        } catch (exception $e) {

           //"php artisan config:clear" to reload changes in .env file.
           if(app()->environment() == 'dev'){

                return $e;

           }else{

                return response()->json('error', 500);

           }

        }
    }



public function searchPatient(Request $request){

    $request->validate([

        'keyword' => 'required|min:3'

    ]);

    $help = new HelperClass();

    $request = $help->sanitize($request->all());

    $patient = new Patient();

    $users = new User();

    $user = Auth::user();

/*
search by last name: , lastname
search by first name: firstname
search by full name: firstname,lastname
*/

        $search_keyword = explode(',', $request['keyword']);

        try {

            $patientResult = null;

            if(sizeof($search_keyword) == 1){

                //format: searchkeyword
                $patientResult =  $patient::where('first_name', 'like', '%'.$request['keyword'].'%')->where('clinic_id', $user['clinic_id'])->get();

            }else if(sizeof($search_keyword) == 2 && strlen(str_replace(' ', '', $search_keyword[0])) > 0 && strlen(str_replace(' ', '', $search_keyword[1])) > 0){

                //format: firstname, lastname
                $search_first_name = str_replace(' ', '', $search_keyword[0]);
                $search_last_name = str_replace(' ', '', $search_keyword[1]);

                $patientResult =  $patient::where(function($query) use($search_first_name, $search_last_name){

                    $query->where('first_name', 'like', '%'.$search_first_name.'%')->
                    orWhere('last_name', 'like', '%'.$search_last_name.'%');

                })->where('clinic_id', $user['clinic_id'])->get();

            }else if(sizeof($search_keyword) == 2 && strlen(str_replace(' ', '', $search_keyword[0])) == 0 && strlen(str_replace(' ', '', $search_keyword[1])) > 0){

                //format: , lastname
                $search_last_name = str_replace(' ', '', $search_keyword[1]);
                $patientResult =  $patient::where('last_name', 'like', '%'.$search_last_name.'%')->where('clinic_id', $user['clinic_id'])->get();

            }else if(sizeof($search_keyword) == 2 && strlen(str_replace(' ', '', $search_keyword[0])) > 0 && strlen(str_replace(' ', '', $search_keyword[1])) == 0){

                //format: , lastname
                $search_first_name = str_replace(' ', '', $search_keyword[0]);
                $patientResult =  $patient::where('first_name', 'like', '%'.$search_first_name.'%')->where('clinic_id', $user['clinic_id'])->get();

            }else{

                $patientResult =  $patient::where(function($query) use($request){

                    $query->where('first_name', 'like', '%'.$request['keyword'].'%')->
                    orWhere('last_name', 'like', '%'.$request['keyword'].'%');

                })->where('clinic_id', $user['clinic_id'])->get();

            }


            foreach($patientResult as $item){

                $createdByUser = $users::where('id', $item['created_by'])->first();

                $item['created_by'] = $createdByUser['first_name'].' '.$createdByUser['last_name'];

                if($item['updated_by'] != null){

                    $updatedByUser = $users::where('id', $item['updated_by'])->first();

                    $item['updated_by'] = $updatedByUser['first_name'].' '.$updatedByUser['last_name'];

                } else{

                    $item['updated_by'] = 'Not available';

                }

                $item['clinic_name'] = $item->assignedClinic->name;

                unset($item->assignedClinic);

                unset($item->createdBy);

                unset($item->updatedBy);

            }

            return response()->json($patientResult, '200');


        } catch (exception $e) {

            //"php artisan config:clear" to reload changes in .env file.
            if(app()->environment() == 'dev'){

                    return $e;

            }else{

                    return response()->json('error', 500);

            }

        }

}

public function getPatient($id){
    $help = new HelperClass();
    $patientId = $help->sanitize($id);
    $patient = new Patient();

    try {

        $patientResult =  $patient::where('id', $patientId)->firstOrFail();
        return response()->json($patientResult, '200');

    } catch (exception $e) {

        //"php artisan config:clear" to reload changes in .env file.
        if(app()->environment() == 'dev'){
                return $e;
        }else{
                return response()->json('error', 500);
        }
    }
}


}
