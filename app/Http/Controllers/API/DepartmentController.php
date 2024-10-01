<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;

class DepartmentController extends Controller
{
    use ApiResponse;


    public function index()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    public function show($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }
        return response()->json($department);
    }


    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'department_code' => 'required|string|unique:hr_mst_department,dep_code',
            'department_name' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'active' => 'required|boolean',
        ]);

        try {
            $userResponse = Http::withHeaders([
                'Authorization' => $request->header('Authorization')
            ])->get('http://localhost:8001/api/user');

        } catch (\Exception $e) {
            Log::error('Error connecting to user service', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to verify user'], 500);
        }

        if (!$userResponse->ok()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = [
            'dep_code' => $validatedData['department_code'],
            'dep_name' => $validatedData['department_name'],
            'dep_remark' => $validatedData['remark'] ?? null,
            'dep_status' => $validatedData['active'],

        ];

        try {
            $department = Department::create($data);
            Log::info('Department created', ['department_id' => $department->id]);
            return $this->successResponse($department, 'Department created successfully', 201);

        } catch (\Exception $e) {
            Log::error('Error creating department', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
    public function update(Request $request, $id)
    {

        $department = Department::find($id);
        if (!$department) {
            return $this->errorResponse('Department not found', 404);
        }

        $validatedData = $request->validate([
            'department_code' => 'required|string|unique:hr_mst_department,dep_code,' . $id, // Ignore the current department's code for uniqueness
            'department_name' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'active' => 'required|boolean',
        ]);

        // Update the department's fields
        $department->dep_code = $validatedData['department_code'];
        $department->dep_name = $validatedData['department_name'];
        $department->dep_remark = $validatedData['remark'] ?? null;
        $department->dep_status = $validatedData['active'] ? 1 : 0; // Convert boolean to integer (1 or 0)

        // Save the updated department
        try {
            $department->save();
            return $this->successResponse($department, 'Department updated successfully', 200);
        } catch (\Exception $e) {
            Log::error('Error updating department', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Server Error'], 500);
        }
    }

    // Delete a department
    public function destroy($id)
    {

        $department = Department::find($id);
        if (!$department) {
            return $this->errorResponse('Department not found', 404);
        }
        $department->dep_is_deleted = 1;
        $department->save();

        return response()->json(['message' => 'Department deleted successfully']);
    }
}
