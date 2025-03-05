<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgramme;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class TrainingProgrammeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $trainingProgramme = TrainingProgramme::all();
        return response()->json($trainingProgramme);
    }

    public function show($id)
    {
        $trainingProgramme = TrainingProgramme::find($id);
        if (!$trainingProgramme) {
            return response()->json(['message' => 'Training Programme not found'], 404);
        }
        return response()->json($trainingProgramme);
    }

    public function store(Request $request)
    {
        $trainingProgramme = new TrainingProgramme();
        $trainingProgramme->htp_name = $request->htp_name;
        $trainingProgramme->htp_category_id = $request->htp_category_id;
        $trainingProgramme->htp_type_id = $request->htp_type_id;
        $trainingProgramme->htp_is_domestic = $request->htp_is_domestic;
        $trainingProgramme->htp_country_id = $request->htp_country_id;
        $trainingProgramme->htp_institute = $request->htp_institute;
        $trainingProgramme->htp_period = $request->htp_period;
        $trainingProgramme->htp_amount = $request->htp_amount;
        $trainingProgramme->htp_bond_required = $request->htp_bond_required;
        $trainingProgramme->htp_bond_value = $request->htp_bond_value;
        $trainingProgramme->htp_bond_period = $request->htp_bond_period;
        $trainingProgramme->HTP_remark = $request->HTP_remark;
        $trainingProgramme->HTP_status= $request->HTP_status;
        $trainingProgramme->save();
        return $this->successResponse($trainingProgramme, 'Data Saved Successfully', 200);
    }

    // Edit an existing department
    public function update(Request $request, $id)
    {
        $trainingProgramme = TrainingProgramme::find($id);
        if (!$trainingProgramme) {
            return $this->errorResponse('Training Programme not found', 404);
        }
        $trainingProgramme->htp_name = $request->htp_name;
        $trainingProgramme->htp_category_id = $request->htp_category_id;
        $trainingProgramme->htp_type_id = $request->htp_type_id;
        $trainingProgramme->htp_is_domestic = $request->htp_is_domestic;
        $trainingProgramme->htp_country_id = $request->htp_country_id;
        $trainingProgramme->htp_institute = $request->htp_institute;
        $trainingProgramme->htp_period = $request->htp_period;
        $trainingProgramme->htp_amount = $request->htp_amount;
        $trainingProgramme->htp_bond_required = $request->htp_bond_required;
        $trainingProgramme->htp_bond_value = $request->htp_bond_value;
        $trainingProgramme->htp_bond_period = $request->htp_bond_period;
        $trainingProgramme->HTP_remark = $request->HTP_remark;
        $trainingProgramme->HTP_status= $request->HTP_status;
        $trainingProgramme->save();

        return $this->successResponse($trainingProgramme,'Training Programme updated successfully', 200);
    }

    // Delete a department
    public function destroy($id)
    {
        $trainingProgramme = TrainingProgramme::find($id);
        if (!$trainingProgramme) {
            return $this->errorResponse('Training Programme not found', 404);
        }

        $trainingProgramme->delete();

        return response()->json(['message' => 'Training Programme deleted successfully']);
    }
}
