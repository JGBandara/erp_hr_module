<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeHistoryRequest;
use App\Services\AuthService;
use App\Services\EmployeeHistoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EmployeeHistoryController extends Controller
{
    use ApiResponse;

    private EmployeeHistoryService $employeeHistoryService;
    private AuthService $authService;

    public function __construct(EmployeeHistoryService $employeeHistoryService, AuthService $authService)
    {
        $this->employeeHistoryService = $employeeHistoryService;
        $this->authService = $authService;
    }

    public function store(StoreEmployeeHistoryRequest $request){

        if($this->authService->checkPermission($request, 'add','human-resource/employee/employment-history/add-new')){
            $validatedData = $request->validated();
            $this->employeeHistoryService->store($validatedData);
            return $this->successResponse();
        }
        return $this->errorResponse("You don't have permission to add employee history",[],401);


    }
    public function getAllBelongsTo(int $id, Request $request){
        try {
            return $this->successResponse($this->employeeHistoryService->getAllBelongsTo($id));
        }catch (\Exception $e){
            return $this->successResponse([]);
        }
    }
}
