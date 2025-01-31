<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\LeaveBalanceService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LeaveBalanceController extends Controller
{
    use ApiResponse;

    private LeaveBalanceService $leaveBalanceService;
    private AuthService $authService;

    public function __construct(LeaveBalanceService $leaveBalanceService, AuthService $authService)
    {
        $this->leaveBalanceService = $leaveBalanceService;
        $this->authService = $authService;
    }

    public function add(Request $request)
    {
        try {
            $user = $this->authService->getAuthUser($request);
            $request->merge(['created_by'=>$user['id']]);
//            $request->all()['created_by'] = $user['id'];
//            return $request->all();
            return $this->successResponse($this->leaveBalanceService->store($request->all()));
        } catch (UnauthorizedException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (CRUDException $e) {
            return $this->errorResponse($e->getMessage());
        }

    }

    public function getLeaveBalances($empId)
    {
        return $this->successResponse($this->leaveBalanceService->getAllByEmployeeId($empId));
    }
    public function getSelf(Request $request){
        try {
            $user = $this->authService->getAuthUser($request);
            return $this->successResponse($this->leaveBalanceService->getAllByEmployeeId($user['emp_id']));
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage(),[],401);
        }
    }
}
