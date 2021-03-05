<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Http\Helper\HelperClass;
use Exception;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => []]);       
        
    }

    public function getCountries(Request $request){

        $request -> validate([

            'language' => 'string|max:3'
        ]);


        try{

            $help = new HelperClass;
            $request =$help -> sanitize($request->all());
    
            $lang = strtolower($request['language']);
    
            $country = new Country();
    
            $country_list = $country::all($lang, 'code');
    
            return response()->json($country_list, 200);

        }catch(exception $e){

            if(app()->environment() == 'dev'){

                return $e;

           }else{

                return response()->json('error', 500);

           } 
        
        }
   

    }
}
