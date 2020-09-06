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
      

        $dob_Month = $request['month'];

        $dob_Date = $request['date'];

        $dob_Year = $request['year'];               
       
        $date = strtotime($dob_Month."/".$dob_Date."/". $dob_Year); 

        $request['date_of_birth'] = date('Y-m-d H:i:s', $date); 

        try {
            
            $help = new HelperClass();

            $request = $help->sanitize($request->all());
    
            $patient = new Patient();
    
            $user = Auth::user();
    
            $patientCheck = $patient::where('email', $request['email'])->get();            
    
            if(isset($patientCheck)){

                foreach($patientCheck as $item){

                    $patientClinicId = $item->createdBy->clinic_id;

                    if($user['clinic_id'] == $patientClinicId){

                        return response()->json('Patient already exists for this clinic', 500);
    
                    }

                }  

            }
    
            $patient->first_name = $request['first_name'];
            $patient->last_name = $request['last_name'];
            $patient->date_of_birth = $request['date_of_birth'];
            $patient->gender = $request['gender'];
            $patient->email = $request['email'];
            $patient->created_by = $user['id'];
    
            $patient->save();

            $sendEmail = new EmailController();

            $newPatient = Patient::where('email', $request['email'])->where('created_by', $user['id'])->first();

            $sendEmail->sendPatientRegistrationEmail($newPatient['email'], $newPatient, 'ENG');
    
            return response()->json('success', 200);                

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

        try {
            
            $patientResult =  $patient::where(function($query) use($request){

                $query->where('first_name', 'like', '%'.$request['keyword'].'%')->
                orWhere('last_name', 'like', '%'.$request['keyword'].'%');
        
            })->get();

            $ptByClinicId = [];

            foreach($patientResult as $item){                

                if($item->createdBy->clinic_id == $user['clinic_id']){
                    
                    unset($item->createdBy);

                    unset($item->updatedBy);

                    $createdByUser = $users::where('id', $item['created_by'])->first();

                    $item['created_by'] = $createdByUser['first_name'].' '.$createdByUser['last_name'];

                    if($item['updated_by'] != null){                        

                        $updatedByUser = $users::where('id', $item['updated_by'])->first();

                        $item['updated_by'] = $updatedByUser['first_name'].' '.$updatedByUser['last_name'];

                    } else{

                        $item['updated_by'] = 'Not available';

                    }

                    array_push($ptByClinicId, $item);

                }

            }

            return response()->json($ptByClinicId, '200');
            

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
