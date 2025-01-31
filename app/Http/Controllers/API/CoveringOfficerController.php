<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Mail\RequestMail;
use App\Services\AuthService;
use App\Services\CoveringOfficerService;
use App\Services\PersonalDetailsService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CoveringOfficerController extends Controller
{
    use ApiResponse;

    private CoveringOfficerService $coveringOfficerService;
    private AuthService $authService;
    private PersonalDetailsService $personalDetailsService;

    public function __construct(CoveringOfficerService $coveringOfficerService, AuthService $authService, PersonalDetailsService $personalDetailsService)
    {
        $this->coveringOfficerService = $coveringOfficerService;
        $this->authService = $authService;
        $this->personalDetailsService = $personalDetailsService;
    }

    public function getOfficers(int $id, int $empId)
    {
        return $this->successResponse($this->coveringOfficerService->getOfficersByCategotyId($id, $empId));
    }
    public function setOfficer(Request $request){
        $data = $request->all();
        $user = $this->authService->getAuthUser($request);

        try {
            $officer = $this->coveringOfficerService->getCoveringOfficerByEmployeeAndOfficerId($data['emp_id'], $data['covering_officer_id']);
            $this->coveringOfficerService->updateStatus($officer->id,false,0);
        }catch (CRUDException $e){
            $this->coveringOfficerService->store($data['emp_id'],$data['covering_officer_id'],$user['id'],$data['location_id']);
        }
        return $data;
    }
    public function removeOfficer($empId, $officerId, Request $request){
        $data = $request->all();
        $user = $this->authService->getAuthUser($request);

        try {
            $officer = $this->coveringOfficerService->getCoveringOfficerByEmployeeAndOfficerId($empId, $officerId);
            $this->coveringOfficerService->updateStatus($officer->id,true,$user['id']);
        }catch (CRUDException $e){
        }
        return $data;
    }
    public function getOfficersBelongTo(int $empId){
        return $this->successResponse($this->coveringOfficerService->getOfficersBelongsTo($empId));
    }
    public function sendRequest(Request $request){
        try {
            $user = $this->authService->getAuthUser($request);
            $employee = $this->personalDetailsService->getAllDetails($user['emp_id']);
            $this->coveringOfficerService->sendRequest($employee, $request->all());
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage());
        }
    }
    public function accept(Request $request, $empId){
//        return 'lllll';
        try {
            $user = $this->authService->getAuthUser($request);
            return $this->coveringOfficerService->requestAction($user['id'], $empId,true);
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
