<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EbExamType;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class EbExamTypeController extends Controller
{
    use ApiResponse;

        public function index()
        {
            $ebExamType = EbExamType::all();
            return response()->json($ebExamType);

            $ebExamTypeDesignation = EbExamTypeDesignation::all();
            return response()->json($ebExamTypeDesignation);

            $ebExamTypeSubject = EbExamTypeSubject::all();
            return response()->json($ebExamTypeSubject);

        }

        // Load data (Get a specific ebExamType by ID)
        public function show($id)
        {
            $ebExamType = EbExamType::find($id);
            if (!$ebExamType) {
                return response()->json(['message' => 'Exam Type not found'], 404);
            }
            return response()->json($ebExamType);


        }

        // Add a new ebExamType
        public function store(Request $request)
        {
            $ebExamType = new EbExamType();
            $ebExamType->ext_name = $request->ext_name;
            $ebExamType->ext_emp_cat_id = $request->ext_emp_cat_id;
            $ebExamType->ext_grade_id = $request->ext_grade_id;
            $ebExamType->ext_remark = $request->ext_remark;
            $ebExamType->ext_status= $request->ext_status;

            $ebExamTypeDesignation = new EbExamTypeDesignation();
            $ebExamTypeDesignation->extd_exam_type_id = $request->extd_exam_type_id;
            $ebExamTypeDesignation->extd_designation_id = $request->extd_designation_id;
            $ebExamTypeDesignation->extd_remark = $request->extd_remark;
            $ebExamTypeDesignation->extd_status= $request->extd_status;

            $ebExamTypeSubject = new EbExamTypeSubject();
            $ebExamTypeSubject->exts_exam_type_id = $request->exts_exam_type_id;
            $ebExamTypeSubject->exts_subject = $request->exts_subject;
            $ebExamTypeSubject->exts_remark = $request->exts_remark;
            $ebExamTypeSubject->exts_status= $request->exts_status;

            $ebExamType->save();
            $ebExamTypeDesignation->save();
            $ebExamTypeSubject->save();

            return $this->successResponse($ebExamType, 'Data Saved Successfully', 200);
        }

        // Edit an existing ebExamType
        public function update(Request $request, $id)
        {
            $ebExamType = EbExamType::find($id);
            if (!$ebExamType) {
                return $this->errorResponse('ebExamType not found', 404);
            }

            $ebExamType->ext_name = $request->ext_name;
            $ebExamType->ext_emp_cat_id = $request->ext_emp_cat_id;
            $ebExamType->ext_grade_id = $request->ext_grade_id;
            $ebExamType->ext_remark = $request->ext_remark;
            $ebExamType->ext_status= $request->ext_status;
            $ebExamType->save();


            $ebExamTypeDesignation = EbExamTypeDesignation::find($id);

            $ebExamTypeDesignation->extd_exam_type_id = $request->extd_exam_type_id;
            $ebExamTypeDesignation->extd_designation_id = $request->extd_designation_id;
            $ebExamTypeDesignation->extd_remark = $request->extd_remark;
            $ebExamTypeDesignation->extd_status= $request->extd_status;

            $ebExamTypeSubject = EbExamTypeSubject::find($id);

            $ebExamTypeSubject->exts_exam_type_id = $request->exts_exam_type_id;
            $ebExamTypeSubject->exts_subject = $request->exts_subject;
            $ebExamTypeSubject->exts_remark = $request->exts_remark;
            $ebExamTypeSubject->exts_status= $request->exts_status;
            return $this->successResponse($ebExamType,'Exam Type updated successfully', 200);
        }

        // Delete a ebExamType
        public function destroy($id)
        {
            $ebExamType = EbExamType::find($id);
            if (!$ebExamType) {
                return $this->errorResponse('Exam Type not found', 404);
            }
            $ebExamTypeDesignation = EbExamTypeDesignation::find($id);
            $ebExamTypeSubject = EbExamTypeSubject::find($id);
            $ebExamType->delete();

            return response()->json(['message' => 'Exam Type deleted successfully']);
        }
    }
