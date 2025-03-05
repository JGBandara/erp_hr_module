<?php

use App\Http\Controllers\API\ApprovalController;
use App\Http\Controllers\API\CoveringOfficerController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\DependentController;
use App\Http\Controllers\API\DesignationController;
use App\Http\Controllers\API\DistrictsController;
use App\Http\Controllers\API\DivisionController;
use App\Http\Controllers\API\DocumentTypeController;
use App\Http\Controllers\API\EbExamController;
use App\Http\Controllers\API\EbExamTypeController;
use App\Http\Controllers\API\EducationQualificationController;
use App\Http\Controllers\API\EmployeeCategoryController;
use App\Http\Controllers\API\EmployeeHistoryController;
use App\Http\Controllers\API\LeaveApprovalOfficerController;
use App\Http\Controllers\API\LeaveBalanceController;
use App\Http\Controllers\API\LeaveRequestController;
use App\Http\Controllers\API\LeaveTypeController;
use App\Http\Controllers\API\MovementController;
use App\Http\Controllers\API\PersonalDetailsController;
use App\Http\Controllers\API\QualificationController;
use App\Http\Controllers\API\ResignTypeController;
use App\Http\Controllers\API\TrainingProgrammeController;
use App\Http\Controllers\API\TypeController;
use App\Http\Controllers\EmployeeTrainingHistoryController;
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



Route::post('/departments/add', [DepartmentController::class, 'store']);
Route::put('/departments/update', [DepartmentController::class, 'update']);
Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);
Route::get('/departments/all', [DepartmentController::class, 'getAll']);
Route::get('/departments/{id}', [DepartmentController::class, 'getById']);

Route::post('/employee-category/add', [EmployeeCategoryController::class, 'store']);
Route::put('/employee-category/update', [EmployeeCategoryController::class, 'update']);
Route::delete('/employee-category/{id}', [EmployeeCategoryController::class, 'destroy']);
Route::get('/employee-category/all', [EmployeeCategoryController::class, 'getAll']);
Route::get('/employee-category/{id}', [EmployeeCategoryController::class, 'getById']);

Route::post('/division/add', [DivisionController::class, 'store']);
Route::put('/division/update', [DivisionController::class, 'update']);
Route::delete('/division/{id}', [DivisionController::class, 'destroy']);
Route::get('/division/all', [DivisionController::class, 'getAll']);
Route::get('/division/{id}', [DivisionController::class, 'getById']);

Route::post('/designation/add', [DesignationController::class, 'store']);
Route::put('/designation/update', [DesignationController::class, 'update']);
Route::delete('/designation/{id}', [DesignationController::class, 'destroy']);
Route::get('/designation/all', [DesignationController::class, 'getAll']);
Route::get('/designation/{id}', [DesignationController::class, 'getById']);

Route::post('/qualification/add', [EducationQualificationController::class, 'store']);
Route::put('/qualification/update', [EducationQualificationController::class, 'update']);
Route::delete('/qualification/{id}', [EducationQualificationController::class, 'destroy']);
Route::get('/qualification/all', [EducationQualificationController::class, 'getAll']);
Route::get('/qualification/{id}', [EducationQualificationController::class, 'getById']);

Route::post('/eb-exam-type/add', [EbExamTypeController::class, 'store']);
Route::put('/eb-exam-type/update', [EbExamTypeController::class, 'update']);
Route::delete('/eb-exam-type/{id}', [EbExamTypeController::class, 'destroy']);
Route::get('/eb-exam-type/all', [EbExamTypeController::class, 'index']);
Route::get('/eb-exam-type/{id}', [EbExamTypeController::class, 'show']);

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

Route::get('/resignType/getAll', [ResignTypeController::class, 'index']);
Route::get('/resignType/{id}', [ResignTypeController::class, 'getAllDetails']);
Route::post('/resignType', [ResignTypeController::class, 'store']);
Route::put('/resignType/{id}', [ResignTypeController::class, 'update']);
Route::delete('/resignType/{id}', [ResignTypeController::class, 'destroy']);

Route::get('/leaveType/getAll', [LeaveTypeController::class, 'index']);
Route::get('/leaveType/{id}', [LeaveTypeController::class, 'getAllDetails']);
Route::post('/leaveType', [LeaveTypeController::class, 'store']);
Route::put('/leaveType/{id}', [LeaveTypeController::class, 'update']);
Route::delete('/leaveType/{id}', [LeaveTypeController::class, 'destroy']);

Route::get('/personalDetails/getAssignedEmployees',[PersonalDetailsController::class,'getAllAssignedEmployeesForLeaveApproval']);

Route::post('/personalDetails/add',[PersonalDetailsController::class,'store']);
Route::get('/personalDetails/allForUsers',[PersonalDetailsController::class,'getAllForUsers']);
Route::get('/personalDetails/all',[PersonalDetailsController::class,'getAll']);
Route::get('/personalDetails/{id}',[PersonalDetailsController::class,'getAllDetails']);
Route::put('/personalDetails/{id}',[PersonalDetailsController::class,'update']);
Route::put('/setProfilePic',[PersonalDetailsController::class,'addImageKey']);
Route::get('/personalDetails/getEmployeeByPPNO/{no}',[PersonalDetailsController::class,'getEmployeeByPersonalFileNo']);
Route::get('/personalDetails/get/self',[PersonalDetailsController::class,'getSelf']);

Route::get('/employeeTrainingHistory/add',[EmployeeTrainingHistoryController::class,'store']);

Route::post('/employee/history/add',[EmployeeHistoryController::class,'store']);
Route::get('/employee/history/getAll/{id}',[EmployeeHistoryController::class,'getAllBelongsTo']);
Route::post('/employee/education/ol',[QualificationController::class,'storeOL']);
Route::get('/employee/education/ol/{id}',[QualificationController::class,'getOLResults']);
Route::post('/employee/education/al',[QualificationController::class,'storeAL']);
Route::get('/employee/education/al/{id}',[QualificationController::class,'getALResults']);
Route::post('/employee/education/prof',[QualificationController::class,'storeProfessionalQualifications']);
Route::get('/employee/education/prof/{id}',[QualificationController::class,'getProfessionalQualifications']);

Route::post('/employee/dependent/add',[DependentController::class,'store']);
Route::get('/employee/dependent/{id}',[DependentController::class,'getAll']);

Route::get('/hr/types/all', [TypeController::class,'getAll']);

Route::post('/leaveRequest/add',[LeaveRequestController::class,'store']);
Route::put('/leaveRequest/update',[LeaveRequestController::class,'update']);
Route::post('/leaveRequest/attachments/add',[LeaveRequestController::class,'saveAttachments']);
Route::get('/leaveRequest/all',[LeaveRequestController::class,'getAll']);
Route::get('/leaveRequest/get/{id}',[LeaveRequestController::class,'getById']);

Route::get('/employee/coveringOfficers/{id}/{empId}',[CoveringOfficerController::class,'getOfficers']);
Route::post('/employee/coveringOfficers',[CoveringOfficerController::class,'setOfficer']);
Route::delete('/employee/coveringOfficers/{empId}/{officerId}',[CoveringOfficerController::class,'removeOfficer']);
Route::get('/employee/coveringOfficerBelongsTo/{empId}',[CoveringOfficerController::class,'getOfficersBelongTo']);

Route::post('/employee/movement/add',[MovementController::class,'store']);
Route::get('/employee/movements/{id}',[MovementController::class,'getByEmpId']);

Route::post('/leaveApproveOfficer/add',[LeaveApprovalOfficerController::class,'store']);
Route::get('/leaveApproveOfficer/get/{empId}/{level}',[LeaveApprovalOfficerController::class,'getOfficers']);

Route::post('/approve/add',[ApprovalController::class,'store']);
Route::post('/approve',[ApprovalController::class,'approve']);
Route::get('/approve/previous/{requestId}/{typeId}',[ApprovalController::class,'getPreviousApprovals']);

Route::post('/leaveBalance/add',[LeaveBalanceController::class,'add']);
Route::get('/leaveBalance/getAll/{empId}',[LeaveBalanceController::class,'getLeaveBalances']);
Route::get('/leaveBalance/get/self',[LeaveBalanceController::class,'getSelf']);

Route::post('/mail/request-mail',[CoveringOfficerController::class,'sendRequest']);

Route::get('/covering-officer/request/accept/{empId}',[CoveringOfficerController::class,'accept']);

Route::post('/documentTypes/add',[DocumentTypeController::class,'store']);
Route::put('/documentTypes/update',[DocumentTypeController::class,'update']);
Route::delete('/documentTypes/delete/{id}',[DocumentTypeController::class,'delete']);
Route::get('/documentTypes/getAll',[DocumentTypeController::class,'getAll']);
Route::get('/documentTypes/get/{id}',[DocumentTypeController::class,'getById']);
