<?php

use Illuminate\Http\Request;

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

Route::group([
    'prefix' => 'v1'

], function ($router) {
// /api/patients
    Route::middleware('jwt.auth', 'cors')->resource('patients', v1\PatientController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/doctors
    Route::middleware('jwt.auth', 'cors')->resource('doctors', v1\DoctorController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/physiotherapists
    Route::middleware('jwt.auth', 'cors')->resource('physiotherapists', v1\PhysiotherapistController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/therapies
    Route::middleware('jwt.auth', 'cors')->resource('therapies', v1\TherapyController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/programs
    Route::middleware('jwt.auth', 'cors')->resource('programs', v1\ProgramController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/work_results
    Route::middleware('jwt.auth', 'cors')->resource('work_results', v1\WorkResultController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/pains
    Route::middleware('jwt.auth', 'cors')->resource('pains', v1\PainController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/mobilities
    Route::middleware('jwt.auth', 'cors')->resource('mobilities', v1\MobilityController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/plans
    Route::/*middleware('jwt.auth', 'cors')->*/resource('plans', v1\PlanController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/sessions
    Route::middleware('jwt.auth', 'cors')->resource('sessions', v1\SessionController::class, [
        'except' => ['create', 'edit']
    ]);

// /api/payment_types
    Route::middleware('jwt.auth', 'cors')->resource('payment_types', v1\PaymentTypeController::class, [
        'except' => ['create', 'edit']
    ]);
// /api/payments
    Route::middleware('jwt.auth', 'cors')->resource('payments', v1\PaymentController::class, [
        'except' => ['create', 'edit']
    ]);

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