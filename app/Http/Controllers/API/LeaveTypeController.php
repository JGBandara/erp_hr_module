<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeaveTypeRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Services\LeaveTypeService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeaveTypeController extends Controller
{
    use ApiResponse;

    private LeaveTypeService $leaveTypeService;

    public function __construct(LeaveTypeService $leaveTypeService)
    {
        $this->leaveTypeService = $leaveTypeService;
    }

    public function index()
    {
        return $this->successResponse($this->leaveTypeService->getAll());
    }

    public function store(StoreLeaveTypeRequest $request)
    {
//        return $request->all();
        $validatedData = $request->validated();
        try {
            $data = $this->leaveTypeService->store($validatedData);
            return $this->successResponse($data, 'Data Saved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([], [$e->getMessage()]);
        }
    }

    public function getAllDetails(int $id)
    {
        try {
            return $this->successResponse($this->leaveTypeService->getAllDetails($id));
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function update(StoreLeaveTypeRequest $request, int $id)
    {
        try {

            Log::info('Update Request Data: ', $request->all());

            $userId = $this->checkPermission($request, 94);
            $validatedData = $request->validated();

            Log::info('Validated Data: ', $validatedData);

            $this->leaveTypeService->update($validatedData, $id, $userId);
            return $this->successResponse();
        } catch (UnauthorizedException $e) {
            return $this->errorResponse([], ["You don't have permission to update Division ...!"], 401);
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage());
        }
    }


    public function destroy(Request $request, $id)
    {
        try {

            $userId = $this->checkPermission($request, 94);

            $leaveType = LeaveType::find($id);
            if (!$leaveType) {
                return $this->errorResponse([], ['Leave Type not found'], 404);
            }

            $leaveType->lv_deleted_by = $userId;
            $leaveType->lv_is_deleted = 1;
            $leaveType->save();


            return $this->successResponse([], 'Leave Type deleted successfully.');
        } catch (UnauthorizedException $e) {
            return $this->errorResponse([], ["You don't have permission to delete this LeaveType...!"], 401);
        } catch (\Exception $e) {
            return $this->errorResponse([], [$e->getMessage()]);
        }
    }

    private function checkPermission(Request $request, int $privilegeId): int
    {
        $response = Http::withHeaders([
            'Authorization' => $request->header('Authorization')
        ])->get('http://localhost:8002/api/permission/check/' . $privilegeId);
        if ($response->status() == 200) {
            return $response['data']['id'];
        }

        throw new UnauthorizedException('Unauthorized...!');
    }
}
