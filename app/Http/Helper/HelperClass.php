<?php

namespace App\Http\Helper;

class HelperClass 
{

    public function celToFar($input){

        //T(°F) = T(°C) × 9/5 + 32

        (double)$f = ((double)$input * (9/5)) + 32;

        return (double)number_format($f, 2);
    }

    public function kgToLbs($input){

        //lb = kg / 0.45359237
        (double)$lbs = (double)$input / 0.45359237;

        return (double)number_format($lbs, 2);
    }

    public function cmToInch($input){

        //inch = cm * 0.39
        (double)$inch = (double)$input * 0.39;

        return (double)number_format($inch, 2);

    }

    public function farToCel($input){

        //T(°C) = (T(°F) - 32) × 5/9
        (double)$cel = ((double)$input - 32)*(5/9);

        return (double)number_format($cel, 1);

    }

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



