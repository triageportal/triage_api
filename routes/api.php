<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckAdmin;

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
Route::post('/createadmin', 'UserController@createAdmin');

//Validates the hash before password update for the new user.
Route::post('/validate-registration', 'UserController@validateRegistration');

//Competes the registration for the new user.
Route::post('/complete-registration','UserController@completeRegistration');

//USER APIs.
//Creates - Pre registers a new user. Must be accesses by Admin, Superuser or Manager.
Route::post('/user', 'UserController@preRegister');

//Search for user info. Must be accesses by Admin, Superuser or Manager.
Route::get('/user','UserController@userSearch');

//Update the user profile. Must be accesses by Admin, Superuser or Manager.
Route::patch('/user', 'UserController@updateUser');

//Reset user password or suspend user. Depends on "action" attribute. Must be accesses by Admin, Superuser or Manager.
Route::put('/user', 'UserController@userResetSuspend');

//Delete user, sets the user status to 'deleted'.
Route::delete('/user','UserController@userDelete');



//CLINIC APIs.
Route::middleware('auth:api','isadmin')->group(

function () {

    //Creates a new clinic. Requires SUPERUSER info as well, auto registers the superuser in USER table.
    Route::post('/clinic','ClinicController@registerClinic');
    //Used to pull the list of clinics by the Admin.
    Route::get('/clinic','ClinicController@clinicSearch');
    //Used to update clinic information.
    Route::patch('/clinic', 'ClinicController@clinicUpdate');
    //Used to delete a clinic.
    Route::delete('/clinic', 'ClinicController@clinicDelete');

});

//Assign clinic_id to the ADMIN user.
Route::middleware('auth:api','isadmin')->patch('/assign-clinic','ClinicController@assignClinic');

//Get language file.
Route::get('/content','LanguageController@getContent');

//Create new patient.
Route::middleware('auth:api')->post('/patientdata', 'PatientController@createPatient');

//Search for a patient.
Route::middleware('auth:api')->get('/patientdata', 'PatientController@searchPatient');

//Vitals routes.
Route::middleware('auth:api')->post('/calc_bmi', 'Vitals\VitalsController@calcBmi');

Route::middleware('auth:api')->post('/vitals', 'Vitals\VitalsController@postVitals');

Route::middleware('auth:api')->get('/vitals', 'Vitals\VitalsController@getVitals');

//Miscellaneous.
Route::middleware('auth:api')->get('/country_list', 'CountryController@getCountries');

//GET FORMS (get the content of triage questionnaire).
Route::middleware('auth:api')->get('/forms_content', 'FormsController@getForm');

//POST ACSS triage results.
Route::middleware('auth:api')->post('/triage/acss', 'Triage\ACSS_ResultsController@createRecord');

//POST Demographics triage results.
Route::middleware('auth:api')->post('/triage/demographics', 'Triage\Demographics_ResultsController@createRecord');

//GET Demographics triage results.
Route::middleware('auth:api')->get('/triage/demographics', 'Triage\Demographics_ResultsController@getLastRecord');

//POST Risk Factor triage results.
Route::middleware('auth:api')->post('/triage/risk_factor', 'Triage\RiskFactor_ResultsController@createRecord');

//POST Premature Ejaculation triage results.
Route::middleware('auth:api')->post('/triage/premature_ejaculation', 'Triage\PremEjac_ResultsController@createRecord');

//GET Last Premature Ejaculation result.
Route::middleware('auth:api')->get('/triage/premature_ejaculation', 'Triage\PremEjac_ResultsController@lastCalculatedResult');
