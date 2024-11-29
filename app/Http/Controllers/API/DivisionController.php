<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDivisionRequest;
use App\Models\Division;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Services\DivisionService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DivisionController extends Controller
{
    use ApiResponse;

    private DivisionService $divisionService;
    private AuthService $authService;

    public function __construct(DivisionService $divisionService, AuthService $authService)
    {
        $this->divisionService = $divisionService;
        $this->authService = $authService;
    }

    public function index()
    {
        return $this->divisionService->getAll();
    }

    public function store(StoreDivisionRequest $request)
    {

        if ($this->authService->checkPermission($request, 'add', 'human-resource/master-data/division/add-new')) {
            $validatedData = $request->validated();
            try {
                $data = $this->divisionService->store($validatedData);
                return $this->successResponse($data, 'Data Saved Successfully', 200);
            } catch (\Exception $e) {
                return $this->errorResponse([], [$e->getMessage()]);
            }
        }

        return $this->errorResponse("You don't have permission to add divisions", [], 401);

    }

    public function getAllDetails(int $id)
    {
        try {
            return $this->successResponse($this->divisionService->getAllDetails($id));
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function update(StoreDivisionRequest $request, $id)
    {
        if ($this->authService->checkPermission($request, 'edit', 'human-resource/master-data/division/add-new')) {
            try {
                $validatedData = $request->validated();
                $userId = $this->authService->getAuthUser($request);

                $this->divisionService->update($validatedData, $id, $userId);
                return $this->successResponse();
            } catch (CRUDException $e) {
                return $this->errorResponse([], $e->getMessage());
            }
        }
        return $this->errorResponse([], ["You don't have permission to update Division ...!"], 401);

    }

    public function destroy(Request $request, $id)
    {
        if ($this->authService->checkPermission($request, 'edit', 'human-resource/master-data/division/add-new')) {
            try {
                $this->divisionService->delete($id);
                return $this->successResponse();
            }catch (CRUDException $e){
                return $this->errorResponse($e->getMessage());
            }

        }
        return $this->errorResponse("You don't have permission to delete division",[],401);
    }
}
