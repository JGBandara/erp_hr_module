<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Services\DivisionService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    use ApiResponse;

    private DivisionService $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->divisionService = $divisionService;
    }

    public function store(StoreDivisionRequest $request)
    {
            $validatedData = $request->validated();
            try {
                $userId = AuthService::getAuthUser($request)['id'];
                $validatedData['created_by'] = $userId;
                $data = $this->divisionService->store($validatedData);
                return $this->successResponse($data, 'Data Saved Successfully', 200);
            } catch (\Exception $e) {
                return $this->errorResponse([], [$e->getMessage()]);
            }
    }

    public function update(UpdateDivisionRequest $request)
    {
        $validatedData = $request->validated();
        $this->divisionService->update($validatedData);
        return $this->successResponse();
    }

    public function getAll()
    {
        return $this->successResponse($this->divisionService->getAll());
    }

    public function getById(int $id)
    {
        try {
            return $this->successResponse($this->divisionService->getById($id));
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function destroy(Request $request, $id)
    {
        if (AuthService::checkPermission($request, 'remove', 'human-resource/master-data/division/add-new')) {
            try {
                $userId = AuthService::getAuthUser($request)['id'];
                $this->divisionService->delete($id, $userId);
                return $this->successResponse();
            }catch (CRUDException $e){
                return $this->errorResponse($e->getMessage());
            }

        }
        return $this->errorResponse("You don't have permission to delete division",[],401);
    }
}
