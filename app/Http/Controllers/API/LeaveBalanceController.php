<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Services\LeaveBalanceService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LeaveBalanceController extends Controller
{
    use ApiResponse;

    private LeaveBalanceService $leaveBalanceService;

    public function __construct(LeaveBalanceService $leaveBalanceService)
    {
        $this->leaveBalanceService = $leaveBalanceService;
    }

    public function add(Request $request)
    {
        try {
            $user = AuthService::getAuthUser($request);
            $request->merge(['created_by'=>$user['id']]);
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
            $user = AuthService::getAuthUser($request);
            return $this->successResponse($this->leaveBalanceService->getAllByEmployeeId($user['emp_id']));
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage(),[],401);
        }
    }
}
