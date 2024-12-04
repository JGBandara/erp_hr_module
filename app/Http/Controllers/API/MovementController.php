<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovementRequest;
use App\Services\MovementService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    use ApiResponse;

    private MovementService $movementService;

    public function __construct(MovementService $movementService)
    {
        $this->movementService = $movementService;
    }

    public function store(StoreMovementRequest $request)
    {
        $validatedData = $request->validated();
        try {
            return $this->successResponse($this->movementService->store($validatedData['items']));
        } catch (CRUDException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function getByEmpId(Request $request, string $id){
        try {
            return $this->successResponse($this->movementService->getBelonsTo($id));
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
