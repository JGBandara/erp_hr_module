<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Services\DesignationService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    use ApiResponse;

    private DesignationService $designationService;

    public function __construct(DesignationService $designationService)
    {
        $this->designationService = $designationService;
    }

    public function store(StoreDesignationRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $userId = AuthService::getAuthUser($request)['id'];
            $validatedData['created_by'] = $userId;
            $data = $this->designationService->store($validatedData);
            return $this->successResponse($data, 'Data Saved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([], [$e->getMessage()]);
        }
    }

    public function update(UpdateDesignationRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->designationService->update($validatedData);
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage());
        }
    }

    public function getAll()
    {
        return $this->successResponse($this->designationService->getAll());
    }

    public function getById(int $id)
    {
        return $this->successResponse($this->designationService->getById($id));
    }

    public function destroy(Request $request, $id)
    {
        if (AuthService::checkPermission($request, 'remove', 'human-resource/master-data/manage-cardre/add-new')) {
            try {
                $userId = AuthService::getAuthUser($request);
                $this->designationService->delete($id, $userId);
                return $this->successResponse();
            } catch (CRUDException|UnauthorizedException $e) {
                return $this->errorResponse($e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to delete designation", [], 401);
    }
}
