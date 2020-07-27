<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['createAdmin']]);
    }

    public function preRegister(Request $request){

        try{

            $users = new User();
            $Carbon = new Carbon();
    
           
            $request->validate([
                'firstName' => 'required|max:50',
                'lastName' => 'required|max:50',
                'email' => 'required|unique:users|email|max:50',            
                'access_type' => 'required'          
               
            ]);
    
            $firstName = filter_var($request['firstName'], FILTER_SANITIZE_STRING);
            $lastName = filter_var($request['lastName'], FILTER_SANITIZE_STRING);
            $email = filter_var($request['email'], FILTER_SANITIZE_STRING);
            $access_type = filter_var($request['access_type'], FILTER_SANITIZE_STRING);
                  
    
                $dateTimeStamp = $Carbon::now()->toDateTimeString();
                $registrationHash = bcrypt($request['email'].$dateTimeStamp);
    
                $user = JWTAuth::parseToken()->toUser();
    
                    $users -> first_name = $request['firstName'];
                    $users -> last_name = $request['lastName'];
                    $users -> email = $request['email'];   
                    $users -> password = NULL;              
                    $users -> role = $request['access_type']; 
                    $users -> access_type = $request['access_type'];               
                    $users -> hospital_id = $user -> hospital_id;
                    $users -> registration_hash = $registrationHash;
                    $users -> active = 0;
    
                    $users -> save();
    
                    return "1";

        }catch(exception $e){

            return "0";

        }

    }


    public function createAdmin(Request $request){

        $users = new User();


        try{

            $request->validate([
                'firstName' => 'required|max:50',
                'lastName' => 'required|max:50',
                'email' => 'required|unique:users|email|max:50',
                'password' => "required|regex: /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|max:32|min:8"                
                   
            ]);


        
                $firstName = filter_var($request['firstName'], FILTER_SANITIZE_STRING);
                $lastName = filter_var($request['lastName'], FILTER_SANITIZE_STRING);
                $email = filter_var($request['email'], FILTER_SANITIZE_STRING);
                $password = filter_var($request['password'], FILTER_SANITIZE_STRING);


                  
    
    
                    $users -> first_name = $firstName;
                    $users -> last_name = $lastName;
                    $users -> email = $email;             
                    $users -> password = bcrypt($password);             
                    $users -> role = "ADMIN";
                    $users -> access_type = "ADMIN";               
                    $users -> hospital_id = 0;
                    $users -> active = 1;
                    $users -> registration_hash = NULL;
    
                    $users -> save();
    
                    return "1";

        }catch(exceptiom $e){

            return "0";

        }
       


    }






}
