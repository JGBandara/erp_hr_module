<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ExceedLeaveLimitException;
use App\Exceptions\IllegalArgumentException;
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
            $validatedData['covering_officer_id'] = $validatedData['covering_officer_id'] ?? 0;

            return $this->successResponse($this->leaveRequestService->store($validatedData));
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage());
        }catch (ExceedLeaveLimitException $e){
            return $this->errorResponse('', $e->getMessage(),403);
        }catch (IllegalArgumentException $e){
            return $this->errorResponse($e->getMessage());
        }
    }
    public function saveAttachments(Request $request){
        $this->leaveRequestService->saveAttachments($request->all()['paths'], $request->all()['request_id']);
    }
    public function update(Request $request){
        try {
            $this->leaveRequestService->update($request->all());
            return $this->successResponse();
        } catch (ExceedLeaveLimitException | UnauthorizedException $e) {
            return $this->errorResponse('', $e->getMessage(), 403);
        }
    }
    public function getAll(){
        return $this->successResponse($this->leaveRequestService->getAll());
    }
    public function getById(Request $request, $id){
        return $this->successResponse($this->leaveRequestService->getById($id));
    }
}
