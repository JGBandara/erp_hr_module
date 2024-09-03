<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\EBExam; 

class EbExamController extends Controller
{
    use ApiResponse;
   
    public function index()
    {
        $ebExam = EbExam::all();
        return response()->json($ebExam);
    }

    // Load data (Get a specific ebExam by ID)
    public function show($id)
    {
        $ebExam = EbExam::find($id);
        if (!$ebExam) {
            return response()->json(['message' => 'Eb Exam not found'], 404);
        }
        return response()->json($ebExam);
    }

    // Add a new ebExam
    public function store(Request $request)
    {
        $ebExam = new EbExam();
        $ebExam->ebx_date = $request->ebx_date;
        $ebExam->ebx_type_id = $request->ebx_type_id;
        $ebExam->ebx_time = $request->ebx_time;
        $ebExam->ebx_venue = $request->ebx_venue;
        $ebExam->ebx_remark = $request->ebx_remark;
        $ebExam->ebx_status= $request->ebx_status;
        $ebExam->save();
        return $this->successResponse($ebExam, 'Data Saved Successfully', 200);
    }

    // Edit an existing ebExam
    public function update(Request $request, $id)
    {
        $ebExam = EbExam::find($id);
        if (!$ebExam) {
            return $this->errorResponse('Eb Exam not found', 404);
        }
        $ebExam->ebx_date = $request->ebx_date;
        $ebExam->ebx_type_id = $request->ebx_type_id;
        $ebExam->ebx_time = $request->ebx_time;
        $ebExam->ebx_venue = $request->ebx_venue;
        $ebExam->ebx_remark = $request->ebx_remark;
        $ebExam->ebx_status= $request->ebx_status;
        $ebExam->save();

        return $this->successResponse($ebExam,'Eb Exam updated successfully', 200);
    }

    // Delete a ebExam
    public function destroy($id)
    {
        $ebExam = EbExam::find($id);
        if (!$ebExam) {
            return $this->errorResponse('Eb Exam not found', 404);
        }

        $ebExam->delete();

        return response()->json(['message' => 'Eb Exam deleted successfully']);
    }
}


