<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\JWTAuth;


class AuthController extends Controller
{
        /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $request -> validate([
            
            'email' => 'required',
            'password' => 'required',
            'currentTime' => 'required'    
        
        ]);
        
            
        $credentials = request(['email', 'password']);

        $userTime = $request['currentTime'];

        $midnightTime = '23:59:59';

        $minutediff = ceil(round((strtotime($midnightTime) - strtotime($userTime))/60, 2));

        //If user local time is 30 mins or less to midnight, we grant 60 minutes.
        if($minutediff<=30){

            $minutediff = 60;

        }

        Auth::factory()->setTTL($minutediff);        

        if (! $token = Auth::attempt($credentials)) {

            return response()->json(['error' => 'Unauthorized'], 401);
            
        }

        //Finds the user that corresponds to the latest created token.
        $user = Auth::user();

        if($user['status'] == 'active'){

            return $this->respondWithToken($token);

        }elseif($user['status'] == 'suspended'){

            return response()->json(['error' => 'suspended'], 401);

        }elseif($user['status'] == 'inactive'){

            return response()->json(['error' => 'inactive'], 401);

        }else{

            return response()->json(['error' => 'Unauthorized'], 401); 

        }
       
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
