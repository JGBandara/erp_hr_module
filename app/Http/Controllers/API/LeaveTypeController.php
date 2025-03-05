<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeaveTypeRequest;
use App\Models\LeaveType;
use App\Services\LeaveTypeService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LeaveTypeController extends Controller
{
    use ApiResponse;

    private LeaveTypeService $leaveTypeService;

    public function __construct(LeaveTypeService $leaveTypeService)
    {
        $this->leaveTypeService = $leaveTypeService;
    }

    public function index()
    {
        return $this->successResponse($this->leaveTypeService->getAll());
    }

    public function store(StoreLeaveTypeRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $data = $this->leaveTypeService->store($validatedData);
            return $this->successResponse($data, 'Data Saved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([], [$e->getMessage()]);
        }
    }

    public function getAllDetails(int $id)
    {
        try {
            return $this->successResponse($this->leaveTypeService->getAllDetails($id));
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function update(StoreLeaveTypeRequest $request, int $id)
    {

        if(AuthService::checkPermission($request,'edit','human-resource/master-data/leave-type/add-new')){
            $validatedData = $request->validated();
            $userId = AuthService::getAuthUser($request)['id'];
            $this->leaveTypeService->update($validatedData, $id, $userId);
            return $this->successResponse();

        }else{
            return $this->errorResponse([], ["You don't have permission to update Division ...!"], 401);

        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            if(!AuthService::checkPermission($request.'remove','human-resource/master-data/leave-type/add-new')){
                return $this->errorResponse([], ["You don't have permission to delete this LeaveType...!"], 401);
            }
            $userId = AuthService::getAuthUser($request);

            $leaveType = LeaveType::find($id);
            if (!$leaveType) {
                return $this->errorResponse([], ['Leave Type not found'], 404);
            }

            $leaveType->lv_deleted_by = $userId;
            $leaveType->lv_is_deleted = 1;
            $leaveType->save();


            return $this->successResponse([], 'Leave Type deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse([], [$e->getMessage()]);
        }
    }
}
