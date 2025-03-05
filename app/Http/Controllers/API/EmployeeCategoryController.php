<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeCategoryRequest;
use App\Http\Requests\UpdateEmployeeCategoryRequest;
use App\Services\EmployeeCategoryService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EmployeeCategoryController extends Controller
{
    use ApiResponse;

    private EmployeeCategoryService $employeeCategoryService;

    public function __construct(EmployeeCategoryService $employeeCategoryService)
    {
        $this->employeeCategoryService = $employeeCategoryService;
    }

    public function store(StoreEmployeeCategoryRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $userId = AuthService::getAuthUser($request)['id'];
            $validatedData['created_by'] = $userId;
            $data = $this->employeeCategoryService->store($validatedData);
            return $this->successResponse($data, 'Data Saved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

    }

    public function update(UpdateEmployeeCategoryRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $this->employeeCategoryService->update($validatedData);
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage());
        }

    }

    public function getAll()
    {
        return $this->successResponse($this->employeeCategoryService->getAll());
    }


    public function getById(int $id)
    {
//        return "hello";
        try {
            return $this->successResponse($this->employeeCategoryService->getById($id));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        if (AuthService::checkPermission($request, 'remove', 'human-resource/master-data/employee-category/add-new')) {
            try {
                $userId = AuthService::getAuthUser($request)['id'];
                $data = ['emp_cat_is_deleted' => 1];

                return $this->successResponse($this->employeeCategoryService->delete($data, $id, $userId));
            } catch (UnauthorizedException $e) {
                return $this->errorResponse($e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to remove employee category", [], 401);
    }
}
