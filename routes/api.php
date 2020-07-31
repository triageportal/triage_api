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


Route::post('/super', 'RegistrationController@preRegister');

//Used to create the first ADMIN user. Admin user is the IT Admin, whoch can create SUPERUSER, MANAGER and REGULAR users.
Route::post('/createadmin', 'RegistrationController@createAdmin');

Route::post('/validate-registration', 'RegistrationController@validateRegistration');

Route::post('/complete-registration','RegistrationController@completeRegistration');

Route::get('/search-by-email','RegistrationController@userSearchByEmail');