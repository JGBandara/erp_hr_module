<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EducationQualification; 
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class EducationQualificationController extends Controller
    {
        use ApiResponse;
       
            public function index()
            {
                $qualifications = EducationQualification::all();
                return response()->json($qualifications);
            }
        
            // Load data (Get a specific qualification by ID)
            public function show($id)
            {
                $qualification = EducationQualification::find($id);
                if (!$qualification) {
                    return response()->json(['message' => 'EducationQualification not found'], 404);
                }
                return response()->json($qualification);
            }
        
            // Add a new qualification
            public function store(Request $request)
            {
                $qualification = new EducationQualification();
                $qualification->qua_name = $request->qua_name;
                $qualification->qua_remark = $request->qua_remark;
                $qualification->qua_status= $request->qua_status;
                $qualification->save();
                return $this->successResponse($qualification, 'Data Saved Successfully', 200);
            }
        
            // Edit an existing qualification
            public function update(Request $request, $id)
            {
                $qualification = EducationQualification::find($id);
                if (!$qualification) {
                    return $this->errorResponse('EducationQualification not found', 404);
                }
               
                $qualification->qua_name = $request->qua_name;
                $qualification->qua_remark = $request->qua_remark;
                $qualification->qua_status= $request->qua_status;
                $qualification->save();
        
                return $this->successResponse($qualification,'EducationQualification updated successfully', 200);
            }
        
            // Delete a qualification
            public function destroy($id)
            {
                $qualification = EducationQualification::find($id);
                if (!$qualification) {
                    return $this->errorResponse('EducationQualification not found', 404);
                }
        
                $qualification->delete();
        
                return response()->json(['message' => 'EducationQualification deleted successfully']);
            }
        }
        
