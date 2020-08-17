<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Clinic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLink;
use Exception;
use App\Http\Controllers\UserController;
use App\Http\Helper\HelperClass;

class ClinicController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => []]);       
        
    }

    public function registerClinic(Request $request){ 

      
        $request->validate([

            'name' => 'required|max:100',
            'addressLineOne'=>'required|max:255',
            'city'=>'required|max:50',
            'zipCode'=>'required|max:15',
            'stateOrRegion'=>'required|max:50',
            'country'=>'required|max:50',
            'phone'=>'required|max:50',
            'clinicEmail'=>'required|unique:clinics|email|max:50',
            'website'=>'required|max:255',
            'language'=>'required|max:50',  
            'contactPhone'=>'required|max:50',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|unique:users|email|max:50',            
            'position' => 'required' 

        ]);  

      try {

        $help = new HelperClass;  
        $request =$help -> sanitize($request->all());
       

        $user = Auth::user();  
        $clinics = new Clinic();
        $users = new UserController();        

        $newClinic = $this->saveClinic($user, $clinics, $request);

        $users->addSuperUserForClinic($newClinic, $request, $user);        

        return response()->json('success', 200);


      } catch (exception $e) {

        return response()->json($e, 500);

      }

    }



    public function saveClinic($user, $clinics, $request){

        try {
            
        $clinics-> name = $request['name'];
        $clinics-> status = 'active';
        $clinics-> addressLineOne = $request['addressLineOne'];

        if(isset($request['addressLineTwo'])){

            $clinics-> addressLineTwo = $request['addressLineTwo'];

        }else{

            $clinics-> addressLineTwo = null;

        }

        $clinics-> city = $request['city'];
        $clinics-> zipCode = $request['zipCode'];
        $clinics-> stateOrRegion = $request['stateOrRegion'];
        $clinics-> country = $request['country'];
        $clinics-> phone = $request['phone'];
        $clinics-> clinicEmail = $request['clinicEmail'];
        $clinics-> website = $request['website'];
        $clinics-> language = $request['language'];
        $clinics-> contactPhone = $request['contactPhone'];
        $clinics-> contactEmail = $request['email'];
        $clinics-> contactName = $request['first_name'].' '.$request['last_name'];
        $clinics-> created_by = $user['id'];

        $clinics->save();

        $updatedClinics = new Clinic();

        $newClinic = $updatedClinics::where('clinicEmail', $request['clinicEmail'])->firstOrFail();
        
        return $newClinic;

        } catch (exception $e) {

            return $e;

        }


    }
    

public function clinicSearch(Request $request){

    $request -> validate([

        'keyword'=>"required|min:3"

    ]);

    $help = new HelperClass;  
    $request = $help -> sanitize($request->all());

    $clinics = new Clinic(); 
    
    try {
        if($request['keyword'] == '%all%'){

            $clinicsResult = $clinics::all();

            //Replacing created_by id with the user name.
            //Replacing updated_by id with the user name.
            foreach($clinicsResult as $item){

                if( $item['created_by'] != null){

                    $users = new User();

                    $usersResult = $users::where('id',  $item['created_by'])->first();
    
                    $item['created_by'] = $usersResult['first_name'].' '.$usersResult['last_name'];

                }else{

                    $item['created_by'] = 'Not available';

                }

                if($item['edited_by'] != null){

                    $users = new User();

                    $usersResult = $users::where('id',  $item['edited_by'])->first();
                    
                    $item['edited_by'] = $usersResult['first_name'].' '.$usersResult['last_name'];

                }else{

                    $item['edited_by'] = 'Not available';

                }

            } 
 
            
            return response()->json($clinicsResult, 200);
    
        }else{
    
            $clinicsResult = $clinics::where('name', 'like', '%' . $request['keyword'] . '%')->get();

            //Replacing created_by id with the user name.
            //Replacing updated_by id with the user name.
            foreach($clinicsResult as $item){

                if($item['created_by'] != null){

                $users = new User();

                $usersResult = $users::where('id',  $item['created_by'])->first();

                $item['created_by'] = $usersResult['first_name'].' '.$usersResult['last_name'];
                
                }else{

                    $item['created_by'] = 'Not available';

                }

                if($item['edited_by'] != null){

                    $users = new User();
    
                    $usersResult = $users::where('id',  $item['edited_by'])->first();
    
                    $item['edited_by'] = $usersResult['first_name'].' '.$usersResult['last_name'];
    
                    }else{
    
                        $item['edited_by'] = 'Not available';
    
                    }

            } 

          
            return response()->json($clinicsResult, 200);  
    
        }
    } catch (exception $e) {

        return response()->json("error", 500);  

    }
}

public function assignClinic(Request $request){

    $request -> validate([

        "id" => "required|integer"

    ]);

    $help = new HelperClass;  
    $request = $help -> sanitize($request->all());

    $user = Auth::user();
    $clinics = new Clinic();
    $updateUser = new User();

    if($request['id'] == 0 ){

        $userId = $user['id'];

        $updateResult = $updateUser::where('id', $userId)->firstOrFail();

        $updateResult['clinic_id'] = 0;

        $updateResult['last_edited_by'] =  $userId;

        $updateResult -> update();

        return response()->json("success", 200);

    }

    try {
        
        $clinicsResult = $clinics::where('id', $request['id'])->firstOrFail();

        $userId = $user['id'];

        $updateResult = $updateUser::where('id', $userId)->firstOrFail();

        $updateResult['clinic_id'] = $clinicsResult['id'];

        $updateResult['last_edited_by'] =  $userId;

        $updateResult -> update();

        return response()->json("success", 200);

    } catch (exception $e) {

         return response()->json("error", 500);
         
    }


    
}

public function clinicUpdate(Request $request){

    $request->validate([
        
        'id' => 'required|integer',
        'name' => 'required|max:100',
        'addressLineOne'=>'required|max:255',
        'city'=>'required|max:50',
        'zipCode'=>'required|max:15',
        'stateOrRegion'=>'required|max:50',
        'country'=>'required|max:50',
        'phone'=>'required|max:50',
        'clinicEmail'=>'required|email|max:50',
        'website'=>'required|max:255',
        'language'=>'required|max:50',  
        'contactPhone'=>'required|max:50',
        'contactName' => 'required|max:100',        
        'contactEmail' => 'required|email|max:50' 

    ]);  

    $help = new HelperClass;  
    $request =$help -> sanitize($request->all());
   
    $user = Auth::user();  
    $clinics = new Clinic();
   

    $clinicEmailCheck = $clinics::where('clinicEmail', $request['clinicEmail'])->first();

    if(isset($clinicEmailCheck)){

        if($clinicEmailCheck['clinicEmail'] == $request['clinicEmail']){

            return response()->json("This clinic email has been taken.", 500);

        }

    }

    $contactEmailCheck = $clinics::where('contactEmail', $request['contactEmail'])->first();

    if(isset($contactEmailCheck)){

        if($contactEmailCheck['contactEmail'] == $request['contactEmail']){

            return response()->json("This contact email has been taken.", 500);

        }

    }

    $clinicResult = $clinics::where('id', $request['id'])->first();

    if(isset($clinicResult)){

        $clinicResult->name = $request['name']; 
        $clinicResult->addressLineOne = $request['addressLineOne'];

        if(isset($request['addressLineTwo'])){

            $clinicResult->addressLineTwo = $request['addressLineTwo'];

        }else{

            $clinicResult->addressLineTwo = null;

        }        
        
        $clinicResult->city = $request['city'];
        $clinicResult->zipCode = $request['zipCode'];
        $clinicResult->stateOrRegion = $request['stateOrRegion'];
        $clinicResult->country = $request['country'];
        $clinicResult->phone = $request['phone'];
        $clinicResult->clinicEmail = $request['clinicEmail'];
        $clinicResult->website = $request['website'];
        $clinicResult->language = $request['language'];
        $clinicResult->contactPhone = $request['contactPhone'];
        $clinicResult->contactName = $request['contactName'];
        $clinicResult->contactEmail = $request['contactEmail'];
        $clinicResult->edited_by = $user['id'];

        $clinicResult->update();

        return response()->json("success", 200);

    }else{

        return response()->json("No such clinic found.", 500); 

    }
    
}


public function clinicDelete(Request $request){

    $request -> validate([

        "id" => 'required|integer'

    ]);

    
    $help = new HelperClass;  
    $request =$help -> sanitize($request->all());

    $clinics = new Clinic();
    $users = new User();
    $user = Auth::user();

    try {
        
        $clinicResult = $clinics::where('id', $request['id'])->first();

        if(isset($clinicResult)){

            $clinicResult['status'] = 'deleted';

            if(!strpos($clinicResult['clinicEmail'], '(del)')){

                $delEmail = $clinicResult['clinicEmail']."(del)";
    
                $clinicResult['clinicEmail'] = $delEmail;

           }

           if(!strpos($clinicResult['contactEmail'], '(del)')){

                $delEmail = $clinicResult['contactEmail']."(del)";

                $clinicResult['contactEmail'] = $delEmail;

           }
            
            $clinicResult['edited_by'] = $user['id'];

            $clinicResult->update();

            //Deleting all users that belong to this clinic by clinic_id.
            $usersResult = $users::where('clinic_id', $request['id'])->get();

            foreach($usersResult as $item){

               $item['status'] = 'deleted';

               if(!strpos($item['email'], '(del)')){

                    $delEmail = $item['email']."(del)";
        
                    $item['email'] = $delEmail;

               }

               $item['password'] = null;

               $item['registration_hash'] = null;

               $item['last_edited_by'] = $user['id'];

               $item->update();

               return response()->json("success", 200);

            }

        }else{

            return response()->json('No such clinic found', 200);

        }

    } catch (exception $e) {

        

    }

}


}
