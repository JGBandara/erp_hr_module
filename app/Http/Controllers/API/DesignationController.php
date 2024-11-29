<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDesignationRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Services\DesignationService;
use App\Traits\ApiResponse;

class DesignationController extends Controller
{
    use ApiResponse;

    private DesignationService $designationService;
    private AuthService $authService;

    public function __construct(DesignationService $designationService, AuthService $authService)
    {
        $this->designationService = $designationService;
        $this->authService = $authService;
    }

    public function index()
    {
        return $this->successResponse($this->designationService->getAll());
    }


    public function store(StoreDesignationRequest $request)
    {
        if ($this->authService->checkPermission($request, 'add', 'human-resource/master-data/manage-cardre/add-new')) {
            $validatedData = $request->validated();
            try {
                $data = $this->designationService->store($validatedData);
                return $this->successResponse($data, 'Data Saved Successfully', 200);
            } catch (\Exception $e) {
                return $this->errorResponse([], [$e->getMessage()]);
            }
        }
        return $this->errorResponse("You don't have permission to add designation", [], 401);

    }

    public function getAllDetails(Request $request, int $id)
    {
        try {
            $this->authService->getAuthUser($request);
            return $this->successResponse($this->designationService->getAllDetails($id));

        } catch (UnauthorizedException $e){
            return $this->errorResponse($e->getMessage(),[],401);
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function update(StoreDesignationRequest $request, $id)
    {
        if($this->authService->checkPermission($request, 'edit','human-resource/master-data/manage-cardre/add-new')){
            try {
                $userId = $this->authService->getAuthUser($request);
                $validatedData = $request->validated();

                $this->designationService->update($validatedData, $id, $userId);
                return $this->successResponse();
            } catch (UnauthorizedException $e) {
                return $this->errorResponse($e->getMessage(), [], 401);
            } catch (\Exception $e) {
                return $this->errorResponse([], $e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to update Designation",[],401);
    }

    public function destroy(Request $request, $id)
    {
        if($this->authService->checkPermission($request, 'remove','human-resource/master-data/manage-cardre/add-new')){
            try {
                $userId = $this->authService->getAuthUser($request);
                $this->designationService->delete($id, $userId);
                return $this->successResponse();
            }catch (CRUDException $e){
                return $this->errorResponse($e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to delete designation",[],401);
    }
}
