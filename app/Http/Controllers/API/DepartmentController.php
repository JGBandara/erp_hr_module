<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CRUDException;
use App\Exceptions\DepartmentNotFoundException;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Services\AuthService;
use App\Services\DepartmentService;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\SysLogService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use ApiResponse;

    private DepartmentService $departmentService;
    private AuthService $authService;

    public function __construct(DepartmentService $departmentService, AuthService $authService)
    {
        $this->departmentService = $departmentService;
        $this->authService = $authService;
    }


//    public function index()
//    {
//        $departments = Department::where('dep_is_deleted', 0)->get();
//        return response()->json($departments);
//    }

    public function show($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }
        return response()->json($department);
    }


    public function store(StoreDepartmentRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->authService->getAuthUser($request);

        if($this->authService->checkPermission($request, 'add','human-resource/master-data/department/add-new')){
            $data = $this->departmentService->store($validatedData);
            SysLogService::log($user['id'], $request->input('locationId'), 'Added a new department');
            return $this->successResponse($data);
        }

        return $this->errorResponse("You don't have permission to add department",'',401);
    }

    public function update(UpdateDepartmentRequest $request, $id)
    {

        if($this->authService->checkPermission($request,'edit','human-resource/master-data/department/add-new')){
            $user = $this->authService->getAuthUser($request);
            try {
                $validatedData = $request->validated();
                $data = $this->departmentService->update($id, $validatedData);
                SysLogService::log($user['id'],$request->input('locationId'),'Updated a Department');
                return $this->successResponse($data);
            }catch (DepartmentNotFoundException $e){
                return $this->errorResponse($e->getMessage());
            }catch (CRUDException $e){
                return $this->errorResponse($e->getMessage());
            }
        }
        return $this->errorResponse("You don't have permission to edit department",'',401);

    }

    // Delete a department
    public function destroy(Request $request, $id)
    {
        try {
            $this->departmentService->delete($id);
            $user = $this->authService->getAuthUser($request);
            SysLogService::log($user['id'], $request->input('locationId'),'Deleted a department');
            return $this->successResponse('Department deleted successfully');
        }catch (DepartmentNotFoundException $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        if($this->authService->checkPermission($request, 'view','human-resource/master-data/department/list-view')){
            return $this->successResponse($this->departmentService->getAll());
        }
        return $this->errorResponse("You don't have permission to view departments",[],401);
    }
}
