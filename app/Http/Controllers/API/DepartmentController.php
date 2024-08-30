<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $department = Department::create($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Department added successfully!',
            'department' => $department,
        ]);
    }

    public function get($id)
    {
        $department = Department::find($id); // Use the Department model
        if ($department) {
            return response(['status' => 'success', 'department' => $department, 'code' => 200]);
        } else {
            return response(['status' => 'error', 'message' => 'Department not found', 'code' => 404]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $department = Department::find($id); // Use the Department model
        if ($department) {
            $department->update($request->all());
            return response(['status' => 'success', 'department' => $department, 'code' => 200]);
        } else {
            return response(['status' => 'error', 'message' => 'Department not found', 'code' => 404]);
        }
    }

    public function delete($id)
    {
        $department = Department::find($id); // Use the Department model
        if ($department) {
            $department->delete();
            return response(['status' => 'success', 'message' => 'Department deleted successfully', 'code' => 200]);
        } else {
            return response(['status' => 'error', 'message' => 'Department not found', 'code' => 404]);
        }
    }
}
