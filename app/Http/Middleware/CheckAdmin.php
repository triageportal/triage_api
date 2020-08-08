<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;



use Closure;

class CheckAdmin 
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $adminCheck = Auth::user();  

        if($adminCheck['access_type'] != 'admin'){
    
            return response()->json('admin access denied', 401);        
    
        }


        return $next($request);

        
    }
}
