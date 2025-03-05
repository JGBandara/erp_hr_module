<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeHistoryRequest;
use App\Services\EmployeeHistoryService;
use App\Services\Util\AuthService;
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

    public function store(StoreEmployeeHistoryRequest $request)
    {
        $validatedData = $request->validated();
        $this->employeeHistoryService->store($validatedData);
        return $this->successResponse();
    }

    public function getAllBelongsTo(int $id, Request $request)
    {
        try {
            return $this->successResponse($this->employeeHistoryService->getAllBelongsTo($id));
        } catch (\Exception $e) {
            return $this->successResponse([]);
        }
    }
}
