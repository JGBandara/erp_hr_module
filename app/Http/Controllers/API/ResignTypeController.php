<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResignTypeRequest;
use App\Models\ResignType; 
use App\Services\ResignTypeService;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResignTypeController extends Controller
{
    use ApiResponse;
    private ResignTypeService $resignTypeService;

    public function __construct(ResignTypeService $resignTypeService){
        $this->resignTypeService=$resignTypeService;
    }

    public function index()
    {
        return $this->resignTypeService->getAll();
    }


    public function getAllDetails(int $id)
    {
        try {
            return $this->successResponse($this->resignTypeService->getAllDetails($id));
        }catch (\Exception $e){
            return $this->errorResponse();
        }
    }

    public function store(StoreResignTypeRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $data = $this->resignTypeService->store($validatedData);
            return $this->successResponse($data,'Data saved successful',200);
        }catch (\Exception $e){
            return $this->errorResponse([],[$e->getMessage()]);
        }
    }

    public function update(StoreResignTypeRequest $request, $id)
    {
        try{
            Log::info('Update Request Data: ', $request->all());
            
            $userId =  $this->checkPermission($request, 94);
            $validatedData = $request->validated();

            Log::info('Validated Data: ', $validatedData);

            $this->resignTypeService->update($validatedData, $id, $userId);
            return $this->successResponse();
        }catch (UnauthorizedException $e){
            return $this->errorResponse([],["You don't have permission to update Resign Type...!"],401);
        }catch (\Exception $e){
            return $this->errorResponse([],$e->getMessage());
        }
    }

    private function checkPermission(Request $request, int $privilegeId):int{
        $response = Http::withHeaders([
            'Authorization' => $request->header('Authorization')
        ])->get('http://localhost:8002/api/permission/check/'.$privilegeId);
        if($response->status() == 200){
            return $response['data']['id'];
        }

        throw new UnauthorizedException('Unauthorized...!');
}
  
    public function destroy($id)
    {
         $resignType = ResignType::find($id);
        if (!$resignType) {
            return $this->errorResponse('Resign Type not found', 404);
        }
        $userId = $this->checkPermission($request, 94);
        $resignType->rsg_deleted_by = $userId;
        $resignType->rsg_is_deleted = 1;
        $resignType->save();

        return response()->json(['message' => 'Resign Type deleted successfully']);
 
    }
}
