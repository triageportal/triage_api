<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Http\Helper\HelperClass;
use Illuminate\Support\Facades\Auth;
use Exception;


class PatientController extends Controller
{
    
    public function createPatient(Request $request){

        $request -> validate([

            'first_name'=>'required',
            'last_name'=>'required',
            'date_of_birth'=>'required|date',
            'gender'=>'required',
            'email'=>'required|email'      

        ]);

        try {
            
            $help = new HelperClass();

            $request = $help->sanitize($request->all());
    
            $patient = new Patient();
    
            $user = Auth::user();
    
            $patientCheck = $patient::where('email', $request['email'])->first();            
    
            if(isset($patientCheck)){

                $patientClinicId = $patientCheck->createdBy->clinic_id;

                if($user['clinic_id'] == $patientClinicId){
    
                    return response()->json('Patient already exists for this clinic', 500);

                }
    
            }else{
    
                $patient->first_name = $request['first_name'];
                $patient->last_name = $request['last_name'];
                $patient->date_of_birth = $request['date_of_birth'];
                $patient->gender = $request['gender'];
                $patient->email = $request['email'];
                $patient->created_by = $user['id'];
        
                $patient->save();
        
                return response()->json('success', 200);
    
            }

        } catch (exception $e) {
            
            return response()->json('error', 500);

        }        
    }








}
