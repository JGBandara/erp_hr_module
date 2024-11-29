<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DependentStoreRequest;
use App\Services\AuthService;
use App\Services\DependantService;
use App\Traits\ApiResponse;

class DependentController extends Controller
{
    use ApiResponse;
    private DependantService $dependantService;
    private AuthService $authService;
    public function __construct(DependantService $dependantService, AuthService $authService)
    {
        $this->dependantService = $dependantService;
        $this->authService = $authService;
    }
    public function store(DependentStoreRequest $request){
        if($this->authService->checkPermission($request,'add','human-resource/employee/dependents/add-new')){
            $validatedData = $request->validated();
            return $this->successResponse($this->dependantService->store($validatedData));
        }
        return $this->errorResponse("You don't have permission to add dependant",[],401 );
    }
    public function getAll(int $id){
        return $this->successResponse($this->dependantService->getAll($id));
    }
}
