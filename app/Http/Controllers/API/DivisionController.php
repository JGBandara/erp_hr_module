<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Division; 
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class DivisionController extends Controller
{
        use ApiResponse;
       
            public function index()
            {
                $division = Division::all();
                return response()->json($division);
            }
        
            // Load data (Get a specific division by ID)
            public function show($id)
            {
                $division = Division::find($id);
                if (!$division) {
                    return response()->json(['message' => 'Division not found'], 404);
                }
                return response()->json($division);
            }
        
            // Add a new division
            public function store(Request $request)
            {
                $division = new Division();
                $division->div_code = $request->div_code;
                $division->div_name = $request->div_name;
                $division->div_dep_id = $request->div_dep_id;
                $division->div_head = $request->div_head;
                $division->div_remark = $request->div_remark;
                $division->div_status= $request->div_status;
                $division->save();
                return $this->successResponse($division, 'Data Saved Successfully', 200);
            }
        
            // Edit an existing division
            public function update(Request $request, $id)
            {
                $division = Division::find($id);
                if (!$division) {
                    return $this->errorResponse('Division not found', 404);
                }
                $division->div_code = $request->div_code;
                $division->div_name = $request->div_name;
                $division->div_dep_id = $request->div_dep_id;
                $division->div_head = $request->div_head;
                $division->div_remark = $request->div_remark;
                $division->div_status= $request->div_status;
                $division->save();
        
                return $this->successResponse($division,'Division updated successfully', 200);
            }
        
            // Delete a division
            public function destroy($id)
            {
                $division = Division::find($id);
                if (!$division) {
                    return $this->errorResponse('Division not found', 404);
                }
        
                $division->delete();
        
                return response()->json(['message' => 'Division deleted successfully']);
            }
        }
        