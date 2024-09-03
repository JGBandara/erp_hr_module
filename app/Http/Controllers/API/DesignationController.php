<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Designation; 
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class DesignationController extends Controller
{
    use ApiResponse;
       
    public function index()
    {
        $designation = Designation::all();
        return response()->json($designation);
    }

    // Load data (Get a specific designation by ID)
    public function show($id)
    {
        $designation = Designation::find($id);
        if (!$designation) {
            return response()->json(['message' => 'Designation not found'], 404);
        }
        return response()->json($designation);
    }

    // Add a new designation
    public function store(Request $request)
    {
        $designation = new Designation();
        $designation->div_code = $request->div_code;
        $designation->div_name = $request->div_name;
        $designation->div_dep_id = $request->div_dep_id;
        $designation->div_head = $request->div_head;
        $designation->div_remark = $request->div_remark;
        $designation->div_status= $request->div_status;
        $designation->save();
        return $this->successResponse($designation, 'Data Saved Successfully', 200);
    }

    // Edit an existing designation
    public function update(Request $request, $id)
    {
        $designation = Designation::find($id);
        if (!$designation) {
            return $this->errorResponse('Designation not found', 404);
        }
        $designation->div_code = $request->div_code;
        $designation->div_name = $request->div_name;
        $designation->div_dep_id = $request->div_dep_id;
        $designation->div_head = $request->div_head;
        $designation->div_remark = $request->div_remark;
        $designation->div_status= $request->div_status;
        $designation->save();

        return $this->successResponse($designation,'designation updated successfully', 200);
    }

    // Delete a designation
    public function destroy($id)
    {
        $designation = Designation::find($id);
        if (!$designation) {
            return $this->errorResponse('Designation not found', 404);
        }

        $designation->delete();

        return response()->json(['message' => 'Designation deleted successfully']);
    }
}