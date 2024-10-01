<?php

use App\Http\Controllers\API\DistrictsController;
use App\Http\Controllers\API\PersonalDetailsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController;
// use App\Http\Controllers\API\LeaveTypeController; // Import the LeaveTypeController
use App\Http\Controllers\API\EmployeeCategoryController;
use App\Http\Controllers\API\DivisionController;
use App\Http\Controllers\API\DesignationController;
use App\Http\Controllers\API\EducationQualificationController;
use App\Http\Controllers\API\EbExamTypeController;
use App\Http\Controllers\API\EbExamController;
use App\Http\Controllers\API\TrainingProgrammeController;
use App\Http\Controllers\API\ResignTypeController;
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



//Route::group(['middleware' => ['auth:api']], function () {
    Route::post('departments', [DepartmentController::class, 'store']);
    Route::put('departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('departments/{id}', [DepartmentController::class, 'destroy']);
//});

Route::get('/departments/all', [DepartmentController::class, 'index']);
Route::get('/departments/{id}', [DepartmentController::class, 'show']);
Route::get('/category', [EmployeeCategoryController::class, 'index']);
Route::get('/category/{id}', [EmployeeCategoryController::class, 'show']);
Route::post('/category', [EmployeeCategoryController::class, 'store']);
Route::put('/category/{id}', [EmployeeCategoryController::class, 'update']);
Route::delete('/category/{id}', [EmployeeCategoryController::class, 'destroy']);
Route::get('/division', [DivisionController::class, 'index']);
Route::get('/division/{id}', [DivisionController::class, 'show']);
Route::post('/division', [DivisionController::class, 'store']);
Route::put('/division/{id}', [DivisionController::class, 'update']);
Route::delete('/division/{id}', [DivisionController::class, 'destroy']);
Route::get('/designation', [DesignationController::class, 'index']);
Route::get('/designation/{id}', [DesignationController::class, 'show']);
Route::post('/designation', [DesignationController::class, 'store']);
Route::put('/designation/{id}', [DesignationController::class, 'update']);
Route::delete('/designation/{id}', [DesignationController::class, 'destroy']);
Route::get('/qualification', [EducationQualificationController::class, 'index']);
Route::get('/qualification/{id}', [EducationQualificationController::class, 'show']);
Route::post('/qualification', [EducationQualificationController::class, 'store']);
Route::put('/qualification/{id}', [EducationQualificationController::class, 'update']);
Route::delete('/qualification/{id}', [EducationQualificationController::class, 'destroy']);
Route::get('/ebExamType', [EbExamTypeController::class, 'index']);
Route::get('/ebExamType/{id}', [EbExamTypeController::class, 'show']);
Route::post('/ebExamType', [EbExamTypeController::class, 'store']);
Route::put('/ebExamType/{id}', [EbExamTypeController::class, 'update']);
Route::delete('/ebExamType/{id}', [EbExamTypeController::class, 'destroy']);
Route::post('/ebExamTypeDesignation', [EbExamTypeController::class, 'index']);
Route::get('/ebExamTypeDesignation/{id}', [EbExamTypeController::class, 'show']);
Route::post('/ebExamTypeDesignation', [EbExamTypeController::class, 'store']);
Route::put('/ebExamTypeDesignation/{id}', [EbExamTypeController::class, 'update']);
Route::delete('/ebExamTypeDesignation/{id}', [EbExamTypeController::class, 'destroy']);
Route::post('/ebExamTypeSubject', [EbExamTypeController::class, 'index']);
Route::get('/ebExamTypeSubject/{id}', [EbExamTypeController::class, 'show']);
Route::post('/ebExamTypeSubject', [EbExamTypeController::class, 'store']);
Route::put('/ebExamTypeSubject/{id}', [EbExamTypeController::class, 'update']);
Route::delete('/ebExamTypeSubject/{id}', [EbExamTypeController::class, 'destroy']);
Route::post('/EBExam', [EbExamController::class, 'index']);
Route::get('/EBExam/{id}', [EbExamController::class, 'show']);
Route::post('/EBExam', [EbExamController::class, 'store']);
Route::put('/EBExam/{id}', [EbExamController::class, 'update']);
Route::delete('/EBExam/{id}', [EbExamController::class, 'destroy']);
Route::post('/trainingProgramme', [TrainingProgrammeController::class, 'index']);
Route::get('/trainingProgramme/{id}', [TrainingProgrammeController::class, 'show']);
Route::post('/trainingProgramme', [TrainingProgrammeController::class, 'store']);
Route::put('/trainingProgramme/{id}', [TrainingProgrammeController::class, 'update']);
Route::delete('/trainingProgramme/{id}', [TrainingProgrammeController::class, 'destroy']);
Route::post('/resignType', [ResignTypeController::class, 'index']);
Route::get('/resignType/{id}', [ResignTypeController::class, 'show']);
Route::post('/resignType', [ResignTypeController::class, 'store']);
Route::put('/resignType/{id}', [ResignTypeController::class, 'update']);
Route::delete('/resignType/{id}', [ResignTypeController::class, 'destroy']);

// Route::post('/leave-types', [LeaveTypeController::class, 'store']);

Route::post('/personalDetails/add',[PersonalDetailsController::class,'store']);
Route::get('/personalDetails/allForUsers',[PersonalDetailsController::class,'getAllForUsers']);
Route::get('/personalDetails/{id}',[PersonalDetailsController::class,'getAllDetails']);
Route::put('/personalDetails/{id}',[PersonalDetailsController::class,'update']);
