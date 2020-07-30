<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth; 
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLink;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['createAdmin', 'validateRegistration', 'completeRegistration']]);
    }

    public function preRegister(Request $request){

        

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
    
                    $users -> first_name = $firstName;
                    $users -> last_name = $lastName;
                    $users -> email = $email;   
                    $users -> password = NULL;              
                    $users -> role = $access_type; 
                    $users -> access_type = $access_type;               
                    $users -> hospital_id = $user -> hospital_id;
                    $users -> registration_hash = $registrationHash;
                    $users -> active = 0;
    
                    //$users -> save();

                    
                    $this -> sendMail($user->first_name, $email, $registrationHash);
    
                    return "1";
       

    }


    public function createAdmin(Request $request){

        $users = new User();


       

            $request->validate([
                'firstName' => 'required|max:50',
                'lastName' => 'required|max:50',
                'email' => 'required|unique:users|email|max:50',
                'password' => "required|regex: /^(?=.{1,})(?=.*[1-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[(!@#$%^&*()_+|~\- =\`{}[\]:”;'<>?,.\/, )])(?!.*(.)\1{2,})(?!.*\s).+$/|max:32|min:8"                 
                   
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

       
       


    }


public function validateRegistration(Request $request){

        $users = new User();

        $request-> validate([
            'registrationHash' => 'required'
        ]);

        $registrationHash =  $request['registrationHash'];
       

        try{

        $result = $users::where('registration_hash', $registrationHash)->firstOrFail();

        return $result;  

        }catch(exception $e){

            return "0";

        }  

    }

public function completeRegistration(Request $request){

    $users = new User();

    $request-> validate([
        'registrationHash' => 'required',
        'password' => "required|regex: /^(?=.{1,})(?=.*[1-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[(!@#$%^&*()_+|~\- =\`{}[\]:”;'<>?,.\/, )])(?!.*(.)\1{2,})(?!.*\s).+$/|max:32|min:8"  
    ]);

    $registrationHash = $request['registrationHash'];
    $password = bcrypt($request['password']);

    try{

        $result = $users::where('registration_hash', $registrationHash)->firstOrFail();

        if(isset($result)){

            $users -> password = $password;

            $users -> save();

        }

    }catch(exception $e){

        return "0";

    }




}


public function sendMail($requestor, $email, $link){

    Mail::to($email)->send(new SendLink($link, $requestor));

}



}
