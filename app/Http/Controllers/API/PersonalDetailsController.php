<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonalDetailsRequest;
use App\Http\Requests\UpdateProfilePicRequest;
use App\Services\AuthService;
use App\Services\PersonalDetailsService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class PersonalDetailsController extends Controller
{
    use ApiResponse;
    private PersonalDetailsService $personalDetailsService;
    private AuthService $authService;

    public function __construct(PersonalDetailsService $personalDetailsService, AuthService $authService){
        $this->personalDetailsService = $personalDetailsService;
        $this->authService = $authService;
    }

    public function store(StorePersonalDetailsRequest $request){
        if($this->authService->checkPermission($request, 'add','human-resource/employee/personal-details/add-new')){
            $validatedData = $request->validated();
            try {
                $data = $this->personalDetailsService->store($validatedData);
                return $this->successResponse($data,'Data saved successful',200);
            }catch (\Exception $e){
                return $this->errorResponse([],[$e->getMessage()]);
            }
        }
        return $this->errorResponse("You don't have permission to add personal details",[],401);

    }

    public function addImageKey(UpdateProfilePicRequest $request){
        $validatedData = $request->validated();
        $this->personalDetailsService->updateImgKey($validatedData['emp_id'], $validatedData['key']);
        return $this->successResponse();
    }

    public function getAllForUsers(){
        return $this->successResponse($this->personalDetailsService->getAllOnlyIdAndFullName());
    }
    public function getAllDetails(int $id){
        try {
            return $this->successResponse($this->personalDetailsService->getAllDetails($id));
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAll(Request $request){
        if($this->authService->checkPermission($request, 'view','human-resource/employee/personal-details/add-new')){
            try {
                return $this->successResponse($this->personalDetailsService->getAll());
            }catch (\Exception $e){
                return $this->errorResponse();
            }
        }
        return $this->errorResponse("You don't have permission to view personal details",[], 401);

    }

    public function update(StorePersonalDetailsRequest $request, int $id){

        if($this->authService->checkPermission($request, 'edit','human-resource/employee/personal-details/add-new')){
            try{
                $userId =  $this->authService->getAuthUser($request);
                $validatedData = $request->validated();
                $data = $this->personalDetailsService->update($validatedData, $id, (int)$userId);
                return $this->successResponse($data);
            }catch (\Exception $e){
                return $this->errorResponse([],$e->getMessage());
            }
        }
        return $this->errorResponse([],["You don't have permission to update personal details"],401);

    }
    public function getEmployeeByPersonalFileNo(string $no, Request $request){
        try {
            return $this->successResponse($this->personalDetailsService->getDetailsByEmpNo($no));
        }catch (CRUDException $e){
            return $this->errorResponse($e->getMessage());
        }
    }
    public function getAllAssignedEmployeesForLeaveApproval(Request $request){
        $empId = $this->authService->getAuthUser($request)['emp_id'];

        return $this->successResponse($this->personalDetailsService->getAllAssignedForApproval($empId));
    }
    public function getSelf(Request $request){
        try {
            $user = $this->authService->getAuthUser($request);
            $empId = $user['emp_id'];
            return $this->successResponse($this->personalDetailsService->getAllDetails($empId));
        }catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage(),[],401);
        }
    }
}
