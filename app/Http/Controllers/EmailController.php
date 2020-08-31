<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLink;
use App\Mail\SendUpdate;
use App\Mail\SendResetLink;
use App\Mail\SendSuspend;
use App\Mail\SendPatientRegistration;

class EmailController extends Controller
{
   



    public function sendRegistrationEmail($user, $email, $language, $link){
    
        Mail::to($email)->send(new SendLink($link, $user, $language));
    
    }
    
    public function sendUpdateEmail($users, $user, $email){
    
        Mail::to($email)->send(new SendUpdate($users, $user));
    
    }
    
    public function sendResetEmail($email, $registrationHash, $language){
    
        Mail::to($email)->send(new SendResetLink($registrationHash, $language));
    
    }
    
    public function sendSuspendEmail($email, $user){
    
        Mail::to($email)->send(new SendSuspend($user));
    
    }

    public function sendPatientRegistrationEmail($email, $patient, $language){
    
        Mail::to($email)->send(new SendPatientRegistration($patient, $language));
    
    }

}
