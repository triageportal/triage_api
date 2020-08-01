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
                'first_name' => 'required|max:50',
                'last_name' => 'required|max:50',
                'email' => 'required|unique:users|email|max:50',            
                'access_type' => 'required',
                'position' => 'required'          
               
            ]);
    
            $firstName = filter_var($request['first_name'], FILTER_SANITIZE_STRING);
            $lastName = filter_var($request['last_name'], FILTER_SANITIZE_STRING);
            $email = filter_var($request['email'], FILTER_SANITIZE_STRING);
            $access_type = filter_var($request['access_type'], FILTER_SANITIZE_STRING);
            $postion = filter_var($request['position'], FILTER_SANITIZE_STRING);
                  
    
                $dateTimeStamp = $Carbon::now()->toDateTimeString();
                $registrationHash = bcrypt($request['email'].$dateTimeStamp);
    
                $user = JWTAuth::parseToken()->toUser();
    
                    $users -> first_name = $firstName;
                    $users -> last_name = $lastName;
                    $users -> email = $email;   
                    $users -> password = NULL;              
                    $users -> position = $postion; 
                    $users -> access_type = $access_type;               
                    $users -> hospital_id = $user -> hospital_id;
                    $users -> registration_hash = $registrationHash;
                    $users -> active = 0;
                    $users -> created_by = $user-> id;
    
                    $users -> save();

                    $language = 'ENG';
                    
                    $this -> sendMail($user, $email, $language, $registrationHash);
                    
    
                    return response()->json('success', 200);
       

    }


    public function createAdmin(Request $request){

        $users = new User();


       

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
                    $users -> position = "admin";
                    $users -> access_type = "admin";               
                    $users -> hospital_id = 0;
                    $users -> active = 1;
                    $users -> registration_hash = NULL;
                    $users -> created_by = NULL;
    
                    $users -> save();
    
                    return response()->json('success', 200);

       
       


    }


public function validateRegistration(Request $request){

        $users = new User();
        
        $request-> validate([
            'registrationHash' => 'required'
        ]);

        $registrationHash =  $request['registrationHash'];
       

        try{

        $result = $users::where('registration_hash', $registrationHash)->firstOrFail();

        return response()->json([ 'user' => $result ]);  

        }catch(exception $e){

            return response()->json('error', 401);

        }  

    }

public function completeRegistration(Request $request){

    $users = new User();

    $request-> validate([
        'registrationHash' => 'required',
        'password' => "required|regex: /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|max:32|min:8"  
    ]);

    $registrationHash = $request['registrationHash'];
    $password = bcrypt($request['password']);

    try{

        $result = $users::where('registration_hash', $registrationHash)->firstOrFail();

        if(isset($result)){

            $result -> password = $password;

            $result -> active = 1;

            $result -> registration_hash = null;

            $result -> update();                    

        }

        return response()->json('success', 200);

    }catch(exception $e){

        return response()->json('error', 401);

    }




}

public function userSearch(Request $request){

    $users = new User();

    $user = Auth::user();

    $request -> validate([

        "keyword" => 'required|min:3'
    ]);


        if($user->access_type != 'regular'){


            if($user->access_type == 'admin'){

                $searchKeyword = $request['keyword'];

                $result = $users::where('first_name', 'like', '%' . $searchKeyword . '%') -> orWhere('last_name', 'like', '%' . $searchKeyword . '%') -> get();        
                 
                foreach($result as $item){

                    $userid = $item -> created_by;

                    $editorid = $item -> last_edited_by;

                    if($userid != null){

                        $result2 = $users::where('id', $userid) -> firstOrFail();
    
                        $item -> created_by = $result2['first_name']." ".$result2['last_name'];
                        
                        }

                    if($editorid != null){

                        $result2 = $users::where('id', $editorid) -> firstOrFail();
    
                        $item -> last_edited_by = $result2['first_name']." ".$result2['last_name'];
                        
                        }
                    
                }


                return response()->json($result, 200);

            }else if($user->access_type == 'manager'){

                $searchKeyword = $request['keyword'];

                $hospitalId = $user -> hospital_id;

                $result = $users::where('first_name', 'like', '%' . $searchKeyword . '%') ->orWhere('last_name', 'like', '%' . $searchKeyword . '%') 
                -> where('hospital_id', $hospitalId) ->where('access_type', '!=', 'admin') ->where('access_type', '!=', 'superuser') -> get();        
                 
                foreach($result as $item){

                    $userid = $item -> created_by;

                    $editorid = $item -> last_edited_by;

                    if($userid != null){

                        $result2 = $users::where('id', $userid) -> firstOrFail();
    
                        $item -> created_by = $result2['first_name']." ".$result2['last_name'];
                        
                        }

                    if($editorid != null){

                        $result2 = $users::where('id', $editorid) -> firstOrFail();
    
                        $item -> last_edited_by = $result2['first_name']." ".$result2['last_name'];
                        
                        }
                    
                }

                return response()->json($result, 200);

            }else if($user->access_type == 'superuser'){

                $searchKeyword = $request['keyword'];

                $hospitalId = $user -> hospital_id;

                $result = $users::where('first_name', 'like', '%' . $searchKeyword . '%') ->orWhere('last_name', 'like', '%' . $searchKeyword . '%') 
                -> where('hospital_id', $hospitalId) ->where('access_type', '!=', 'admin') -> get();        
                 
                foreach($result as $item){

                    $userid = $item -> created_by;

                    $editorid = $item -> last_edited_by;

                    if($userid != null){

                        $result2 = $users::where('id', $userid) -> firstOrFail();
    
                        $item -> created_by = $result2['first_name']." ".$result2['last_name'];
                        
                        }

                    if($editorid != null){

                        $result2 = $users::where('id', $editorid) -> firstOrFail();
    
                        $item -> last_edited_by = $result2['first_name']." ".$result2['last_name'];
                        
                        }
                    
                }
                
                return response()->json($result, 200);

            }


        }else{

            return response()->json('error', 500);

        }

}

public function updateUser(Request $request){

    $request->validate([
        'id' => 'required',
        'first_name' => 'required|max:50',
        'last_name' => 'required|max:50',
        'email' => 'required|email|max:50',            
        'access_type' => 'required',
        'position' => 'required'             
    ]);

    foreach($request as $item){

        $item = filter_var($item, FILTER_SANITIZE_STRING);

    }

    $users = new User();   

    try{

        $emailCheck = $users::where('email', $request['email'])->firstOrFail();

        if($emailCheck['id'] != $request['id']){
            $error['errors']['email'][] = 'The email has already been taken.';
            return response()->json($error, 422);
    
        }

        $result = $users::where('id', $request['id'])->firstOrFail();

        $user = Auth::user();       

        $result -> first_name = $request['first_name'];
        $result -> last_name = $request['last_name'];
        $result -> email = $request['email'];                 
        $result -> position = $request['position']; 
        $result -> access_type = $request['access_type'];               
        $result -> last_edited_by = $user-> id;

        $result -> update();

        return response()->json("success", 200);

    }catch(exception $e){

        return $e;

    }

}


public function sendMail($user, $email, $language, $link){

    
    Mail::to($email)->send(new SendLink($link, $user, $language));

}



}