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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// /api/v1/patients
Route::resource('v1/patients',v1\PatientController::class, [
    'except' => ['create','edit']
]);
// /api/v1/disciplines
Route::resource('v1/disciplines',v1\DisciplineController::class, [
    'except' => ['create','edit']
]);
// /api/v1/doctors
Route::resource('v1/doctors',v1\DoctorController::class, [
    'except' => ['create','edit']
]);