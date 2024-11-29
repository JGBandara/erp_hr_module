<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeCategoryRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Services\EmployeeCategoryService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;

class EmployeeCategoryController extends Controller
{
    use ApiResponse;
    private EmployeeCategoryService $employeeCategoryService;
    private AuthService $authService;

    public function __construct(EmployeeCategoryService $employeeCategoryService, AuthService $authService){
        $this->EmployeeCategoryService=$employeeCategoryService;
        $this->authService = $authService;
    }
    public function index()
    {
        return $this->successResponse($this->EmployeeCategoryService->getAll());
    }


    public function getAllDetails(int $id)
    {
        try {
            return $this->successResponse($this->EmployeeCategoryService->getAllDetails($id));
        }catch (\Exception $e){
            return $this->errorResponse();
        }
    }

    public function store(StoreEmployeeCategoryRequest $request)
    {
        if ($this->authService->checkPermission($request, 'add', 'human-resource/master-data/employee-category/add-new')){
            $validatedData = $request->validated();

            try {
                $data = $this->EmployeeCategoryService->store($validatedData);
                return $this->successResponse($data, 'Data Saved Successfully', 200);
            } catch (\Exception $e) {
                return $this->errorResponse($e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to add employee category",[],401);

    }

    public function update(StoreEmployeeCategoryRequest $request, $id)
    {
        if($this->authService->checkPermission($request, 'edit', 'human-resource/master-data/employee-category/add-new')){
            $validatedData = $request->validated();
            try {
                Log::info('Update Request Data: ', $request->all());
                $userId = $this->authService->getAuthUser($request);

                $this->EmployeeCategoryService->update($validatedData, $id, $userId);
                return $this->successResponse();
            } catch (\Exception $e) {
                return $this->errorResponse([], $e->getMessage());
            }
        }
        return $this->errorResponse([], ["You don't have permission to update Employee Category ...!"], 401);

    }

    public function destroy(Request $request, $id)
    {
        if($this->authService->checkPermission($request, 'remove', 'human-resource/master-data/employee-category/add-new')){
            try {
                $userId = $this->authService->getAuthUser($request);
                $data = ['emp_cat_is_deleted' => 1];
                $this->EmployeeCategoryService->update($data, $id, $userId);
                return $this->successResponse();
            }catch (CRUDException $e){
                return $this->errorResponse('Invalid category', $e->getMessage());
            }
        }

        return $this->errorResponse("You don't have permission to remove employee category",[],401);
    }
}
