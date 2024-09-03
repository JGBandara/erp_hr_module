<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EmployeeCategory; 
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class EmployeeCategoryController extends Controller
{
    use ApiResponse;
   
    public function index()
    {
        $category = EmployeeCategory::all();
        return response()->json($category);
    }

    // Load data (Get a specific department by ID)
    public function show($id)
    {
        $category = EmployeeCategory::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    // Add a new department
    public function store(Request $request)
    {
        $category = new EmployeeCategory();
        $category->emp_code = $request->emp_code;
        $category->emp_name = $request->emp_name;
        $category->emp_level = $request->emp_level;
        $category->emp_rank = $request->emp_rank;
        $category->emp_remark = $request->emp_remark;
        $category->emp_status= $request->emp_status;
        $category->save();
        return $this->successResponse($category, 'Data Saved Successfully', 200);
    }

    // Edit an existing department
    public function update(Request $request, $id)
    {
        $category = EmployeeCategory::find($id);
        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }
        $category->emp_code = $request->emp_code;
        $category->emp_name = $request->emp_name;
        $category->emp_level = $request->emp_level;
        $category->emp_rank = $request->emp_rank;
        $category->emp_remark = $request->emp_remark;
        $category->emp_status= $request->emp_status;
        $category->save();

        return $this->successResponse($category,'Category updated successfully', 200);
    }

    // Delete a department
    public function destroy($id)
    {
        $category = EmployeeCategory::find($id);
        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}