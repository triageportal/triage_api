<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\HelperClass;
use Exception;

class LanguageController extends Controller
{
    
    public function getContent(Request $request){

        $request -> validate([

            'language' => 'required|min:3|max:3'

        ]);

        $help = new HelperClass();
        $request = $help->sanitize($request->all());     

        try {

            $selectLanguage = $request['language'];
                   
            $languageFile = file_get_contents(base_path('\\language_packs\\'.$selectLanguage.'.json'));
            
            return  $languageFile;


        } catch (exception $e) {
            
            return response() -> json('Language file not found', 500);
        
        }


    }

}
