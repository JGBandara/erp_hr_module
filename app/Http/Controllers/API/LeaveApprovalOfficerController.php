<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeaveApprovalOfficerRequest;
use App\Services\AuthService;
use App\Services\LeaveApprovalOfficerService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LeaveApprovalOfficerController extends Controller
{
    use ApiResponse;
    private LeaveApprovalOfficerService $leaveApprovalOfficerService;
    private AuthService $authService;
    public function __construct(LeaveApprovalOfficerService $leaveApprovalOfficerService, AuthService $authService)
    {
        $this->leaveApprovalOfficerService = $leaveApprovalOfficerService;
        $this->authService = $authService;
    }
    public function store(StoreLeaveApprovalOfficerRequest $request){
        $validatedData = $request->validated();
        try {
            $validatedData['user_id'] = $this->authService->getAuthUser($request)['id'];
            return $this->successResponse($this->leaveApprovalOfficerService->store($validatedData));

        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage());
        }
    }
    public function getOfficers(Request $request, $empId, $level){
        return $this->successResponse($this->leaveApprovalOfficerService->getAppravalOfficersByEmpIdAndLevel($empId,$level));
    }
}
