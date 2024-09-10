<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Department; 
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;


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
        public function isValidUser(int $id): JsonResponse{
            return response()->json($this->userService->checkUserById($id));
        }
        // Add a new department
        public function store(Request $request)
        {
            $user  = Http::withHeaders([
                'Authorization' => $request->header('Authorization')
            ])->get('http://localhost:8001/api/user');
    
            // if (!$user) {
                return $user;
            // }
            // if (Gate::denies('add-department')) {
            //     return response()->json(['message' => 'You do not have permission to add a department'], 403);
            // }
    
            // $department = new Department();
            // $department->dep_code = $request->dep_code;
            // $department->dep_name = $request->dep_name;
            // $department->dep_remark = $request->dep_remark;
            // $department->dep_status= $request->dep_status;
            // $department->save();
            // return $this->successResponse($department, 'Data Saved Successfully', 200);
            
        }
    
        // Edit an existing department
        public function update(Request $request, $id)
        {
            if (Gate::denies('edit-department')) {
                return response()->json(['message' => 'You do not have permission to edit this department'], 403);
            }
            $department = Department::find($id);
            if (!$department) {
                return $this->errorResponse('Department not found', 404);
            }
            
            $department->dep_code = $request->dep_code;
            $department->dep_name = $request->dep_name;
            $department->dep_remark = $request->dep_remark;
            $department->dep_status= $request->dep_status;
            $department->save();
    
            return $this->successResponse($department,'Department updated successfully', 200);
        }
    
        // Delete a department
        public function destroy($id)
        {
            if (Gate::denies('delete-department')) {
                return response()->json(['message' => 'You do not have permission to delete this department'], 403);
            }

            $department = Department::find($id);
            if (!$department) {
                return $this->errorResponse('Department not found', 404);
            }
    
            $department->delete();
    
            return response()->json(['message' => 'Department deleted successfully']);
        }
    }
    