<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeCategoryRequest;
use App\Models\EmployeeCategory;
use Illuminate\Http\Request;
use App\Services\EmployeeCategoryService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmployeeCategoryController extends Controller
{
    use ApiResponse;
    private EmployeeCategoryService $employeeCategoryService;

    public function __construct(EmployeeCategoryService $employeeCategoryService){
        $this->EmployeeCategoryService=$employeeCategoryService;
    }
    public function index()
    {
        return $this->EmployeeCategoryService->getAll();
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
        $validatedData = $request->validated();
        try {

            $data = $this->EmployeeCategoryService->store($validatedData);
            return $this->successResponse($data, 'Data Saved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([],[$e->getMessage()]);
        }
    }

    public function update(StoreEmployeeCategoryRequest $request, $id)
    {
        try {

            Log::info('Update Request Data: ', $request->all());

            $userId = $this->checkPermission($request, 94);
            $validatedData = $request->validated();

            Log::info('Validated Data: ', $validatedData);

            $this->EmployeeCategoryService->update($validatedData, $id, $userId);
            return $this->successResponse();
        } catch (UnauthorizedException $e) {
            return $this->errorResponse([], ["You don't have permission to update Employee Category ...!"], 401);
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $category = EmployeeCategory::find($id);
        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }
        $userId = $this->checkPermission($request, 94);
        $category->emp_cat_is_deleted = 1;
        $category->emp_cat_deleted_by = $userId;
        $category->save();

        return response()->json(['message' => 'Category deleted successfully']);
    }
    private function checkPermission(Request $request, int $privilegeId):int{
        $response = Http::withHeaders([
            'Authorization' => $request->header('Authorization')
        ])->get('http://localhost:8002/api/permission/check/'.$privilegeId);

        Log::info('Permission Check Response: ', ['response' => $response->body()]);

        if($response->status() == 200){
            return $response['data']['id'];
        }

        throw new UnauthorizedException('Unauthorized...!');

}
}
