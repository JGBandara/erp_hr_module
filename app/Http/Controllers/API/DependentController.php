<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DependentStoreRequest;
use App\Services\DependantService;
use App\Traits\ApiResponse;

class DependentController extends Controller
{
    use ApiResponse;
    private DependantService $dependantService;
    public function __construct(DependantService $dependantService)
    {
        $this->dependantService = $dependantService;
    }
    public function store(DependentStoreRequest $request){
        $validatedData = $request->validated();
        return $this->successResponse($this->dependantService->store($validatedData));
    }
    public function getAll(int $id){
        return $this->successResponse($this->dependantService->getAll($id));
    }
}
