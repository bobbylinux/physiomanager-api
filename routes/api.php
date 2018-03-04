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
// /api/v1/physiotherapists
Route::resource('v1/physiotherapists',v1\PhysiotherapistController::class, [
    'except' => ['create','edit']
]);
// /api/v1/therapies
Route::resource('v1/therapies',v1\TherapyController::class, [
    'except' => ['create','edit']
]);
// /api/v1/programs
Route::resource('v1/programs',v1\ProgramController::class, [
    'except' => ['create','edit']
]);