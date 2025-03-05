<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEducationQualificationRequest;
use App\Http\Requests\UpdateEducationalQualificationRequest;
use App\Services\EducationQualificationService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EducationQualificationController extends Controller
{
    use ApiResponse;

    private EducationQualificationService $educationQualificationService;

    public function __construct(EducationQualificationService $educationQualificationService)
    {
        $this->educationQualificationService = $educationQualificationService;
    }

    public function store(StoreEducationQualificationRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $validatedData['created_by'] = AuthService::getAuthUser($request)['id'];
//            return $validatedData;
            $data = $this->educationQualificationService->store($validatedData);
            return $this->successResponse($data, 'Data saved successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(UpdateEducationalQualificationRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->educationQualificationService->update($validatedData);
            return $this->successResponse();
        } catch (CRUDException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage());
        }
    }

    public function getAll()
    {
        return $this->educationQualificationService->getAll();
    }

    public function getById(int $id)
    {
        try {
            return $this->successResponse($this->educationQualificationService->getById($id));
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function destroy(Request $request, int $id)
    {
        if (AuthService::checkPermission($request, 'remove', 'human-resource/master-data/education-qualifications/manage')) {
            try {
                $userId = AuthService::getAuthUser($request)['id'];
                $this->educationQualificationService->delete($id, $userId);
                return $this->successResponse();
            } catch (UnauthorizedException $e) {
                return $this->errorResponse($e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to delete education qualification", [], 401);
    }
}
