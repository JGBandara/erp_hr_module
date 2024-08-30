<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController; // Import the DepartmentController
// use App\Http\Controllers\API\LeaveTypeController; // Import the LeaveTypeController

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


Route::get('/departments', [DepartmentController::class, 'index']); 
Route::get('/departments/{id}', [DepartmentController::class, 'show']); 
Route::post('/departments', [DepartmentController::class, 'store']); 
Route::put('/departments/{id}', [DepartmentController::class, 'update']); 
Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']); 
// Route::post('/leave-types', [LeaveTypeController::class, 'store']);
