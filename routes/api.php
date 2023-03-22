<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TeacherController;
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

Route::post('/account/login', [AccountController::class, 'login']);
Route::get('/account/current-user', [AccountController::class, 'get_current_user']);
Route::post('/account/change-password', [AccountController::class, 'change_password']);

Route::get('/survey', [SurveyController::class, 'index']);
Route::post('/survey', [SurveyController::class, 'store']);
Route::get('/survey/{id}', [SurveyController::class, 'show']);
Route::put('/survey/{id}', [SurveyController::class, 'update']);
Route::delete('/survey/{id}', [SurveyController::class, 'destroy']);
Route::post('/survey/submit-form', [SurveyController::class, 'submit_form_survey']);
Route::get('/survey/{survey_id}/answer', [SurveyController::class, 'show_all_answer_by_survey']);
Route::get('/survey/{survey_id}/answer/{user_id}', [SurveyController::class, 'show_survey_answer']);
Route::get('/survey/{id}/option', [SurveyController::class, 'get_option']);

Route::get('/department', [DepartmentController::class, 'index']);
Route::get('/grade-level', [GradeLevelController::class, 'index']);

Route::get('/student', [StudentController::class, 'index']);
Route::post('/student', [StudentController::class, 'store']);
Route::get('/student/{id}', [StudentController::class, 'show']);
Route::put('/student/{id}', [StudentController::class, 'update']);
Route::delete('/student/{id}', [StudentController::class, 'destroy']);

Route::get('/teacher', [TeacherController::class, 'index']);
Route::post('/teacher', [TeacherController::class, 'store']);
Route::get('/teacher/{id}', [TeacherController::class, 'show']);
Route::put('/teacher/{id}', [TeacherController::class, 'update']);
Route::delete('/teacher/{id}', [TeacherController::class, 'destroy']);

Route::get('/subject', [SubjectController::class, 'index']);
Route::post('/subject', [SubjectController::class, 'store']);
Route::get('/subject/{id}', [SubjectController::class, 'show']);
Route::put('/subject/{id}', [SubjectController::class, 'update']);
Route::delete('/subject/{id}', [SubjectController::class, 'destroy']);

Route::get('/class', [ClassController::class, 'index']);
Route::post('/class', [ClassController::class, 'store']);
Route::get('/class/{id}', [ClassController::class, 'show']);
Route::put('/class/{id}', [ClassController::class, 'update']);
Route::delete('/class/{id}', [ClassController::class, 'destroy']);
//hien thi danh sach sinh vien trong lop hoc 
Route::get('/class/{id}/student', [ClassController::class, 'get_list_student']);
//them sinh vien trong lop hoctro
Route::post('/class/{class_id}/student/{student_id}', [ClassController::class, 'add_student_to_class']);
//xoa sinh vien khoi lop hoc 
Route::delete('/class/{class_id}/student/{student_id}', [ClassController::class, 'delete_student_from_class']);

// //hien thi danh sach sinh vien trong lop hoc 
// Route::get('/class/student', [ClassController::class, 'show']);
// //them sinh vien trong lop hoctro
// Route::post('/class/student', [ClassController::class, 'show', 'add']);
// //xoa sinh vien khoi lop hoc 
// Route::delete('/class/student', [ClassCtroller::class, 'show', 'delete']);

//xem ket qua dien bieu mau cua sinh vien/giang vien
//thong ke khao sat

//cai dat bieu mau : chon doi tuong khao sat 
Route::put('/survey/{id}/option', [SurveyController::class, 'update_option']);
