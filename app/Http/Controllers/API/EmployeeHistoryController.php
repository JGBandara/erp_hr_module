<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeHistoryRequest;
use App\Services\EmployeeHistoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EmployeeHistoryController extends Controller
{
    use ApiResponse;

    private EmployeeHistoryService $employeeHistoryService;

    public function __construct(EmployeeHistoryService $employeeHistoryService)
    {
        $this->employeeHistoryService = $employeeHistoryService;
    }

    public function store(StoreEmployeeHistoryRequest $request){

        $validatedData = $request->validated();

        return $this->employeeHistoryService->store($validatedData);
    }
}
