<?php

use App\Http\Controllers\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/survey', [SurveyController::class, 'index']);
Route::post('/survey', [SurveyController::class, 'store']);
Route::get('/survey/{id}', [SurveyController::class, 'show']);
Route::put('/survey/{id}', [SurveyController::class, 'update']);
Route::delete('/survey/{id}', [SurveyController::class, 'destroy']);
Route::post('/survey/submit-form', [SurveyController::class, 'submit_form_survey']);
