<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\DepartmentNotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

//use App\Services\SysLogService;

class DepartmentController extends Controller
{
    use ApiResponse;

    private DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function store(StoreDepartmentRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $userId = AuthService::getAuthUser($request)['id'];
            $validatedData['created_by'] = $userId;
            $data = $this->departmentService->store($validatedData);
            return $this->successResponse($data);
        } catch (UnauthorizedException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(UpdateDepartmentRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $data = $this->departmentService->update($validatedData);
            return $this->successResponse($data);
        } catch (DepartmentNotFoundException|CRUDException $e) {
            return $this->errorResponse($e->getMessage());
        }

    }

    public function destroy(Request $request, $id)
    {
        try {
            $this->departmentService->delete($id);
            $user = AuthService::getAuthUser($request);
            return $this->successResponse('Department deleted successfully');
        } catch (DepartmentNotFoundException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        if (AuthService::checkPermission($request, 'view', 'human-resource/master-data/department/list-view')) {
            return $this->successResponse($this->departmentService->getAll());
        }
        return $this->errorResponse("You don't have permission to view departments", [], 401);
    }
    public function getById($id)
    {
        return $this->successResponse($this->departmentService->getById($id));
    }
}
