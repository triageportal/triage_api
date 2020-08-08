<?php

namespace App\Http\Helper;

class HelperClass 
{

    public function sanitize($request){
        
        $keys = array_keys($request);
       
        for($x = 0; $x < sizeof($request); $x++ ) {

           $request[$keys[$x]] = filter_var($request[$keys[$x]], FILTER_SANITIZE_STRING);

        }

        return $request;

    }




}



