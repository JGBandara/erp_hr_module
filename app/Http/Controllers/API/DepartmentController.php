<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Department; 
use Illuminate\Http\Request;
use App\Traits\ApiResponse;


class DepartmentController extends Controller

{
    use ApiResponse;
   
        public function index()
        {
            $departments = Department::all();
            return response()->json($departments);
        }
    
        // Load data (Get a specific department by ID)
        public function show($id)
        {
            $department = Department::find($id);
            if (!$department) {
                return response()->json(['message' => 'Department not found'], 404);
            }
            return response()->json($department);
        }
    
        // Add a new department
        public function store(Request $request)
        {
            $department = new Department();
            $department->name = $request->name;
            $department->save();
            return $this->successResponse($department, 'Data Saved Successfully', 200);
        }
    
        // Edit an existing department
        public function update(Request $request, $id)
        {
            $department = Department::find($id);
            if (!$department) {
                return response()->json(['message' => 'Department not found'], 404);
            }
            $department->dep_code = $request->dep_code;
            $department->dep_name = $request->dep_name;
            $department->dep_remark = $request->dep_remark;
            $department->dep_status= $request->dep_status;
            $department->save();
    
            return response()->json(['message' => 'Department updated successfully', 'data' => $department]);
        }
    
        // Delete a department
        public function destroy($id)
        {
            $department = Department::find($id);
            if (!$department) {
                return response()->json(['message' => 'Department not found'], 404);
            }
    
            $department->delete();
    
            return response()->json(['message' => 'Department deleted successfully']);
        }
    }
    