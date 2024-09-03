<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LeaveType; 
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class LeaveTypeController extends Controller
{
    use ApiResponse;
   
    public function index()
    {
        $leaveType = LeaveType::all();
        return response()->json($leaveType);
    }

    // Load data (Get a specific leaveType by ID)
    public function show($id)
    {
        $leaveType = LeaveType::find($id);
        if (!$leaveType) {
            return response()->json(['message' => 'Leave Type not found'], 404);
        }
        return response()->json($leaveType);
    }

    // Add a new leaveType
    public function store(Request $request)
    {
        $leaveType = new LeaveType();
        $leaveType->lv_name = $request->lv_name;
        $leaveType->lv_salary_deduct = $request->lv_salary_deduct;
        $leaveType->lv_count_working_days = $request->lv_count_working_days;
        $leaveType->lv_has_limit= $request->lv_has_limit;
        $leaveType->lv_allow_attendance_bonus = $request->lv_allow_attendance_bonus;
        $leaveType->lv_remarks = $request->lv_remarks;
        $leaveType->lv_status= $request->lv_status;
        $leaveType->save();
        return $this->successResponse($leaveType, 'Data Saved Successfully', 200);
    }

    // Edit an existing leaveType
    public function update(Request $request, $id)
    {
        $leaveType = LeaveType::find($id);
        if (!$leaveType) {
            return $this->errorResponse('Leave Type not found', 404);
        }
        $leaveType->lv_name = $request->lv_name;
        $leaveType->lv_salary_deduct = $request->lv_salary_deduct;
        $leaveType->lv_count_working_days = $request->lv_count_working_days;
        $leaveType->lv_has_limit= $request->lv_has_limit;
        $leaveType->lv_allow_attendance_bonus = $request->lv_allow_attendance_bonus;
        $leaveType->lv_remarks = $request->lv_remarks;
        $leaveType->lv_status= $request->lv_status;
        $leaveType->save();

        return $this->successResponse($leaveType,'Leave Type updated successfully', 200);
    }

    // Delete a leaveType
    public function destroy($id)
    {
        $leaveType = leaveType::find($id);
        if (!$leaveType) {
            return $this->errorResponse('Leave Type not found', 404);
        }

        $leaveType->delete();

        return response()->json(['message' => 'Leave Type deleted successfully']);
    }
}

