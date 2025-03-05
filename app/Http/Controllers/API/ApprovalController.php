<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Services\ApprovalService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    use ApiResponse;
    private ApprovalService $approvalService;
    public function __construct(ApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }
    public function store(Request $request){
        $data = $request->all();
        return $this->approvalService->store($data);
    }
    public function approve(Request $request){
        try {
            $user = AuthService::getAuthUser($request);
            $data = $request->all();
            $this->approvalService->approve($data['id'],$user['id'],$data['status'],$data['remark'],$data['type']);
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage(), [], 401);
        }
    }
    public function getPreviousApprovals(Request $request, int $requestId, int $typeId){
        return $this->successResponse($this->approvalService->getPreviousApprovals($requestId, $typeId));
    }
}
