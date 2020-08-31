<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Clinic;
use App\Http\Controllers\EmailController;
use Carbon\Carbon;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth; 
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLink;
use App\Mail\SendUpdate;
use App\Mail\SendResetLink;
use App\Mail\SendSuspend;
use App\Http\Helper\HelperClass;




class UserController extends Controller
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

            $help = new HelperClass;  
            $request = $help -> sanitize($request->all());
            
            $user = JWTAuth::parseToken()->toUser();
            
            if($user['access_type'] == 'admin' && $user['clinic_id'] == 0){

                return response()->json(['admin' =>"Clinic must be assigned first"], 500);

            }
    
            $dateTimeStamp = $Carbon::now()->toDateTimeString();
            $registrationHash = bcrypt($request['email'].$dateTimeStamp);            

            $users -> first_name = $request['first_name'];
            $users -> last_name = $request['last_name'];
            $users -> email = $request['email'];   
            $users -> password = NULL;              
            $users -> position = $request['position']; 
            $users -> access_type = $request['access_type'];               
            $users -> clinic_id = $user -> clinic_id;
            $users -> registration_hash = $registrationHash;
            $users -> status = 'inactive';
            $users -> created_by = $user-> id;

            $users -> save();

            //Pulling assigned clinic's language.
            $clinic = new Clinic;

            $resultClinic = $clinic::where('id', $user['clinic_id'])->first();

            $language = $resultClinic['language'];

            $sendEmail = new EmailController();
            
            $sendEmail->sendRegistrationEmail($user, $request['email'], $language, $registrationHash);
            

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

        $help = new HelperClass;  
        $request = $help -> sanitize($request->all());   

        $users -> first_name = $request['firstName'];
        $users -> last_name = $request['lastName'];
        $users -> email = $request['email'];             
        $users -> password = bcrypt($request['password']);             
        $users -> position = "admin";
        $users -> access_type = "admin";               
        $users -> clinic_id = 0;
        $users -> status = 'active';
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

        $help = new HelperClass;  
        $request = $help -> sanitize($request->all());  

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

    $help = new HelperClass;  
    $request = $help -> sanitize($request->all());  

    $registrationHash = $request['registrationHash'];
    $password = bcrypt($request['password']);

    try{

        $result = $users::where('registration_hash', $registrationHash)->firstOrFail();

        if(isset($result)){

            $result -> password = $password;

            $result -> status = 'active';

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

    $help = new HelperClass;  
    $request = $help -> sanitize($request->all());  


        if($user->access_type != 'regular'){


            if($user->access_type == 'admin'){

                $searchKeyword = $request['keyword'];

                $result = $users::where('status', '!=', 'deleted')->
                where('first_name', 'like', '%' . $searchKeyword . '%') -> 
                orWhere('last_name', 'like', '%' . $searchKeyword . '%') -> 
                get();        
                 
                foreach($result as $item){

                    $userid = $item -> created_by;

                    $editorid = $item -> last_edited_by;

                    if($userid != null){

                        $result2 = $users::where('id', $userid) -> firstOrFail();
    
                        $item -> created_by = $result2['first_name']." ".$result2['last_name'];
                        
                        }else{

                            $item -> created_by = 'Not avaialble';

                        }

                    if($editorid != null){

                        $result2 = $users::where('id', $editorid) -> firstOrFail();
    
                        $item -> last_edited_by = $result2['first_name']." ".$result2['last_name'];
                        
                        }else{

                            $item -> last_edited_by = 'Not available';
                            
                        }
                    
                }


                return response()->json($result, 200);

            }else if($user->access_type == 'manager'){

                $searchKeyword = $request['keyword'];

                $hospitalId = $user -> clinic_id;

                $result = $users::where('first_name', 'like', '%' . $searchKeyword . '%') ->orWhere('last_name', 'like', '%' . $searchKeyword . '%') 
                -> where('clinic_id', $hospitalId) ->where('access_type', '!=', 'admin') ->where('access_type', '!=', 'superuser') -> where('status', '!=', 'deleted') -> 
                get();        
                 
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

                $hospitalId = $user -> clinic_id;

                $result = $users::where('first_name', 'like', '%' . $searchKeyword . '%') ->orWhere('last_name', 'like', '%' . $searchKeyword . '%') 
                -> where('clinic_id', $hospitalId) ->where('access_type', '!=', 'admin') -> where('status', '!=', 'deleted') -> get();        
                 
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
        'id' => 'required|integer',
        'first_name' => 'required|max:50',
        'last_name' => 'required|max:50',
        'email' => 'required|email|max:50',            
        'access_type' => 'required',
        'position' => 'required'             
    ]);

    $help = new HelperClass;  
    $request = $help -> sanitize($request->all());  

    $users = new User();   

    $result = $users::where('id', $request['id'])->first();

    $result -> makeVisible(['password']);

    if($result['password'] != null && strlen($result['password']) > 0){

        try{

            $emailCheck = $users::where('email', $request['email'])->first();
    
            if(isset($emailCheck)){
            
                if($emailCheck['id'] != $request['id']){

                    $error['errors']['email'][] = 'The email has already been taken.';

                    return response()->json($error, 422);
            
                }
            }
    
            $user = Auth::user();       
    
            $result -> first_name = $request['first_name'];
            $result -> last_name = $request['last_name'];
            $result -> email = $request['email'];                 
            $result -> position = $request['position']; 
            $result -> access_type = $request['access_type'];               
            $result -> last_edited_by = $user-> id;
    
            $result -> update();

            $sendEmail = new EmailController();
    
            $sendEmail->sendUpdateEmail($result, $user, $result['email']);
    
            return response()->json("success", 200);
    
        }catch(exception $e){
    
            return response()->json('error', 500);
    
        }
    }else{

        if($request['email'] == $result['email']){

            try {
              
                $user = Auth::user();       
    
                $result -> first_name = $request['first_name'];
                $result -> last_name = $request['last_name'];
                $result -> email = $request['email'];                 
                $result -> position = $request['position']; 
                $result -> access_type = $request['access_type'];               
                $result -> last_edited_by = $user-> id;
        
                $result -> update();
        
                return response()->json("success", 200);

            } catch (exception $e) {

                return response()->json('error', 500);

            }        

        }else{

            try {
              
                    $emailCheck = $users::where('email', $request['email'])->first();
            
                    if(isset($emailCheck)){
                    
                        if($emailCheck['id'] != $request['id']){
                            
                            $error['errors']['email'][] = 'The email has already been taken.';

                            return response()->json($error, 422);
                    
                        }
                    }

                    $Carbon = new Carbon();
                    $dateTimeStamp = $Carbon::now()->toDateTimeString();
                    $registrationHash = bcrypt($request['email'].$dateTimeStamp);

                    $user = JWTAuth::parseToken()->toUser();

                    $result -> first_name = $request['first_name'];
                    $result -> last_name = $request['last_name'];
                    $result -> email = $request['email'];                           
                    $result -> position = $request['position']; 
                    $result -> access_type = $request['access_type'];               
                    $result -> clinic_id = $user -> clinic_id;
                    $result -> registration_hash = $registrationHash;                
                    $result -> last_edited_by = $user-> id;

                    $result -> update();

                    //Pulling assigned clinic's language.
                    $clinic = new Clinic;

                    $resultClinic = $clinic::where('id', $user['clinic_id'])->first();

                    $language = $resultClinic['language'];

                    $sendEmail = new EmailController();

                    $sendEmail -> sendRegistrationEmail($user, $request['email'], $language, $registrationHash);
                    

                    return response()->json('success', 200);
                
            } catch (exception $e) {

                return response()->json('error', 500);

            }

            

        }


    }

}

public function userResetSuspend(Request $request){

    $request -> validate([

        'id' => 'required|integer',
        'action' => 'required'

    ]);

    $help = new HelperClass;  
    $request = $help -> sanitize($request->all());  

    $users = new User();

    $user = Auth::user(); 

    try {

        $result = $users::where('id', $request['id']) -> firstOrFail();
        
        if(isset($result)){

            if($request['action'] == 'reset'){

                $Carbon = new Carbon();

                $dateTimeStamp = $Carbon::now()->toDateTimeString();

                $registrationHash = bcrypt($result['email'].$dateTimeStamp);

                $result -> registration_hash = $registrationHash;  
                
                $result['password'] = null;

                $result->status = 'inactive';

                $result -> last_edited_by = $user-> id;

                $result -> update();

                //Pulling assigned clinic's language.
                $clinic = new Clinic;

                $resultClinic = $clinic::where('id', $user['clinic_id'])->first();

                $language = $resultClinic['language'];

                $sendEmail = new EmailController();

                $sendEmail -> sendResetEmail($result['email'], $registrationHash, $language);

                return response()->json('success', 200);


            }elseif($request['action'] == 'suspend'){

                $result->status = 'suspended';

                $result -> last_edited_by = $user-> id;

                $result->update(); 

                $sendEmail = new EmailController();

                $sendEmail -> sendSuspendEmail($result['email'], $user);

                return response()->json('success', 200);

            }



        }    
       
    } catch (exception $e) {

        return response()->json('error', 500);

    }



}


public function userDelete(Request $request){

    $request -> validate([

        'id' => 'required|integer'

    ]);

    $help = new HelperClass;  
    $request = $help -> sanitize($request->all());  

    $users = new User();

    $user = Auth::user(); 

    $result = [];

    try {

       $result = $users::where('id', $request['id']) -> firstOrFail();
       
       if($result['id'] != $user['id']){
       
            if($user['access_type'] == 'admin'){
                
               $response = $this -> deleteUserCont($result, $user);

               return $response;

            }elseif($user['access_type'] =='superuser'){

                if($result['access_type'] != 'admin' && $result['access_type'] != 'superuser'){

                    $response = $this -> deleteUserCont($result, $user); 
                    
                    return $response;

                }else{

                    return response()->json('unable to delete', 500);

                }

            }elseif($user['access_type'] =='manager'){

                if($result['access_type'] != 'admin' && $result['access_type'] != 'superuser' && $result['access_type'] != 'manager'){

                    $response = $this -> deleteUserCont($result, $user);  

                    return $response;

                }else{

                    return response()->json('unable to delete', 500);

                }

            }  

       }else{

        return response()->json('unable to delete', 500);

        }
       


    } catch (exception $e) {
        
        return response()->json('error', 500);

    }
    
}



public function deleteUserCont($result, $user){

    $current_date_time = Carbon::now()->toDateTimeString();

    if(strpos($result['email'], '(^del^')){

        return response()->json('user already deleted', 500);

    }else{

        $result -> status = 'deleted';

        $delEmail = $result -> email."(^del^".$current_date_time.")";
    
        $result -> email = $delEmail;

        $result -> password = null;

        $result -> registration_hash = null;
            
        $result -> last_edited_by = $user-> id;       
    
        $result -> save();
    
        return response()->json('success', 200);

    }   


}


//This function is used to auto - create superuser for the newly created clinic.
public function addSuperUserForClinic($newClinic, $request, $user){

       
    try {
        $users = new User();
        $Carbon = new Carbon();   
            

        $dateTimeStamp = $Carbon::now()->toDateTimeString();
        $registrationHash = bcrypt($request['email'].$dateTimeStamp);


        $users -> first_name = $request['first_name'];
        $users -> last_name = $request['last_name'];
        $users -> email = $request['email'];   
        $users -> password = NULL;              
        $users -> position = $request['position']; 
        $users -> access_type = 'superuser';               
        $users -> clinic_id = $newClinic['id'];
        $users -> registration_hash = $registrationHash;
        $users -> status = 'inactive';
        $users -> created_by = $user-> id;

        $users -> save();

        $language = $newClinic['language'];

        $sendEmail = new EmailController();
        
        $sendEmail -> sendRegistrationEmail($user, $request['email'], $language, $registrationHash);

    } catch (exception $e) {
        return $e;
    }       
  
}

}