<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me'); 

});

//Used to create the first ADMIN user. Admin user is the IT Admin, who can create SUPERUSER, MANAGER and REGULAR users. 
//Disable the rounte after creating the first user.
Route::post('/createadmin', 'RegistrationController@createAdmin');

//Creates - Pre registers a new user. Must be accesses by Admin, Superuser or Manager.
Route::post('/user', 'RegistrationController@preRegister');

//Validates the hash before password update for the new user.
Route::post('/validate-registration', 'RegistrationController@validateRegistration');

//Competes the registration for the new user.
Route::post('/complete-registration','RegistrationController@completeRegistration');

//Search for user info. Must be accesses by Admin, Superuser or Manager.
Route::get('/user','RegistrationController@userSearch');

//Update the user profile. Must be accesses by Admin, Superuser or Manager.
Route::patch('/user', 'RegistrationController@updateUser');