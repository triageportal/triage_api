<?php

namespace App\Http\Helper;

class HelperClass 
{

    public function calculateBmi($height_cm, $weight_kg){

        //(weight kg / height cm / height cm ) x 10,000 = bmi

        $bmi = (($weight_kg / $height_cm) / $height_cm) * 10000;

        //keeps only 2 decimal points.
        return (double)number_format($bmi, 2);

    }

    public function inchToCm($inch_value){

        $cm_equivalent = 2.54;

        $total_cm = (double)$inch_value * $cm_equivalent;

        //keeps only 2 decimal points.
        return (double)number_format($total_cm, 2);

    }

    public function lbToKg($lb_value){

        $kg_equivalent = 0.45359237;

        $total_kg = (double)$lb_value * $kg_equivalent;

        return (double)number_format($total_kg, 2);

    }

    public function sanitize($request){
        
        $keys = array_keys($request);
       
        for($x = 0; $x < sizeof($request); $x++ ) {

           $request[$keys[$x]] = filter_var($request[$keys[$x]], FILTER_SANITIZE_STRING);

        }

        return $request;

    }




}



