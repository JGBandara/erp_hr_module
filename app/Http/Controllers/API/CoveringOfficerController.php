<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\CoveringOfficerService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CoveringOfficerController extends Controller
{
    use ApiResponse;

    private CoveringOfficerService $coveringOfficerService;
    private AuthService $authService;

    public function __construct(CoveringOfficerService $coveringOfficerService, AuthService $authService)
    {
        $this->coveringOfficerService = $coveringOfficerService;
        $this->authService = $authService;
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
        return $this->coveringOfficerService->getOfficersBelongsTo($empId);
    }
}
