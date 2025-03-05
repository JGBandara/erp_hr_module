<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Services\CoveringOfficerService;
use App\Services\PersonalDetailsService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CoveringOfficerController extends Controller
{
    use ApiResponse;

    private CoveringOfficerService $coveringOfficerService;
    private PersonalDetailsService $personalDetailsService;

    public function __construct(CoveringOfficerService $coveringOfficerService, PersonalDetailsService $personalDetailsService)
    {
        $this->coveringOfficerService = $coveringOfficerService;
        $this->personalDetailsService = $personalDetailsService;
    }

    public function getOfficers(int $id, int $empId)
    {
        return $this->successResponse($this->coveringOfficerService->getOfficersByCategotyId($id, $empId));
    }
    public function setOfficer(Request $request){
        $data = $request->all();
        $user = AuthService::getAuthUser($request);

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
        $user = AuthService::getAuthUser($request);

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
            $user = AuthService::getAuthUser($request);
            $employee = $this->personalDetailsService->getAllDetails($user['emp_id']);
            $this->coveringOfficerService->sendRequest($employee, $request->all());
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage());
        }
    }
    public function accept(Request $request, $empId){
        try {
            $user = AuthService::getAuthUser($request);
            return $this->coveringOfficerService->requestAction($user['id'], $empId,true);
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
