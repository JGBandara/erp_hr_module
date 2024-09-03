<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ResignType; 
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ResignTypeController extends Controller
{
    use ApiResponse;
   
    public function index()
    {
        $resignType = ResignType::all();
        return response()->json($resignType);
    }

    // Load data (Get a specific resignType by ID)
    public function show($id)
    {
        $resignType = ResignType::find($id);
        if (!$resignType) {
            return response()->json(['message' => 'Resign Type not found'], 404);
        }
        return response()->json($resignType);
    }

    // Add a new resignType
    public function store(Request $request)
    {
        $resignType = new ResignType();
        $resignType->name = $request->name;
        $resignType->save();
        return $this->successResponse($resignType, 'Data Saved Successfully', 200);
    }

    // Edit an existing resignType
    public function update(Request $request, $id)
    {
        $resignType = ResignType::find($id);
        if (!$resignType) {
            return $this->errorResponse('Resign Type not found', 404);
        }
        $resignType->dep_code = $request->dep_code;
        $resignType->dep_name = $request->dep_name;
        $resignType->dep_remark = $request->dep_remark;
        $resignType->dep_status= $request->dep_status;
        $resignType->save();

        return $this->successResponse($resignType,'Resign Type updated successfully', 200);
    }

    // Delete a resignType
    public function destroy($id)
    {
        $resignType = ResignType::find($id);
        if (!$resignType) {
            return $this->errorResponse('Resign Type not found', 404);
        }

        $resignType->delete();

        return response()->json(['message' => 'Resign Type deleted successfully']);
    }
}
