<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEducationQualificationRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Services\EducationQualificationService;
use App\Traits\ApiResponse;

class EducationQualificationController extends Controller
{
    use ApiResponse;

    private EducationQualificationService $educationQualificationService;
    private AuthService $authService;

    public function __construct(EducationQualificationService $educationQualificationService, AuthService $authService)
    {
        $this->educationQualificationService = $educationQualificationService;
        $this->authService = $authService;
    }

    public function index()
    {
        return $this->educationQualificationService->getAll();
    }

    public function getAllDetails(int $id)
    {
        try {
            return $this->successResponse($this->educationQualificationService->getAllDetails($id));
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function store(StoreEducationQualificationRequest $request)
    {
        if($this->authService->checkPermission($request, 'add','human-resource/master-data/education-qualifications/manage')){
            $validatedData = $request->validated();
            try {
                $data = $this->educationQualificationService->store($validatedData);
                return $this->successResponse($data, 'Data saved successful', 200);
            } catch (\Exception $e) {
                return $this->errorResponse($e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to add Education qualification",[],401);

    }

    public function update(StoreEducationQualificationRequest $request, $id)
    {
        if($this->authService->checkPermission($request, 'edit','human-resource/master-data/education-qualifications/manage')){
            try {
                $userId = $this->authService->getAuthUser($request);
                $validatedData = $request->validated();
                $this->educationQualificationService->update($validatedData, $id, $userId);
                return $this->successResponse();
            } catch(CRUDException $e){
                return $this->errorResponse($e->getMessage());
            } catch (\Exception $e) {
                return $this->errorResponse([], $e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to update education qualification",[],401);
    }

    public function destroy(Request $request, int $id)
    {
        if($this->authService->checkPermission($request, 'remove','human-resource/master-data/education-qualifications/manage')){
            try {
                $userId = $this->authService->getAuthUser($request);
                $this->educationQualificationService->delete($id, $userId);
                return $this->successResponse();
            }catch (CRUDException $e){
                return $this->errorResponse($e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to delete education qualification", [], 401);
    }
}
