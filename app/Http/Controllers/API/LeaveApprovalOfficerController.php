<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeaveApprovalOfficerRequest;
use App\Services\LeaveApprovalOfficerService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LeaveApprovalOfficerController extends Controller
{
    use ApiResponse;
    private LeaveApprovalOfficerService $leaveApprovalOfficerService;
    public function __construct(LeaveApprovalOfficerService $leaveApprovalOfficerService)
    {
        $this->leaveApprovalOfficerService = $leaveApprovalOfficerService;
    }
    public function store(StoreLeaveApprovalOfficerRequest $request){
        $validatedData = $request->validated();
        try {
            $validatedData['user_id'] = AuthService::getAuthUser($request)['id'];
            return $this->successResponse($this->leaveApprovalOfficerService->store($validatedData));

        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage());
        }
    }
    public function getOfficers(Request $request, $empId, $level){
        return $this->successResponse($this->leaveApprovalOfficerService->getAppravalOfficersByEmpIdAndLevel($empId,$level));
    }
}
