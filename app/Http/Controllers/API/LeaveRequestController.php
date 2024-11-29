<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeaveRequest;
use App\Services\AuthService;
use App\Services\LeaveRequestService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    use ApiResponse;
    private LeaveRequestService $leaveRequestService;
    private AuthService $authService;
    public function __construct(LeaveRequestService $leaveRequestService, AuthService $authService)
    {
        $this->leaveRequestService = $leaveRequestService;
        $this->authService = $authService;
    }
    public function store(StoreLeaveRequest $request){

        try {
            $data = $this->authService->getAuthUser($request);
            $validatedData = $request->validated();
            $validatedData['created_by'] = $data['id'];
            return $this->successResponse($this->leaveRequestService->store($validatedData));
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage());
        }catch (CRUDException $e){
            return $this->errorResponse($e->getMessage());

        }
    }
}
