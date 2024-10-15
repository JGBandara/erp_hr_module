<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDesignationRequest;
use App\Models\Designation; 
use Illuminate\Http\Request;
use App\Services\DesignationService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DesignationController extends Controller
{
    use ApiResponse;
    private DesignationService $designationService;

    public function __construct(DesignationService $designationService){
        $this->designationService = $designationService;
    }
    public function index()
    {
        return $this->designationService->getAll();
    }

    
    public function store(StoreDesignationRequest $request){
        $validatedData = $request->validated();
        try {
                $data = $this->designationService->store($validatedData);
                return $this->successResponse($data, 'Data Saved Successfully', 200);
            } catch (\Exception $e) {
            return $this->errorResponse([],[$e->getMessage()]);
        }
        }

    public function getAllDetails(int $id){
            try {
                return $this->successResponse($this->designationService->getAllDetails($id));
            }catch (\Exception $e){
                return $this->errorResponse();
            }
        }
    
    public function update(StoreDesignationRequest $request, $id) {
        try {
            
            Log::info('Update Request Data: ', $request->all());
    
            $userId = $this->checkPermission($request, 94);
            $validatedData = $request->validated();
            
            Log::info('Validated Data: ', $validatedData);
            
            $this->designationService->update($validatedData, $id, $userId);
            return $this->successResponse();
        } catch (UnauthorizedException $e) {
            return $this->errorResponse([], ["You don't have permission to update Designation ...!"], 401);
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage());
        }
    }
    

   
    public function destroy($id)
    {
        $designation = Designation::find($id);
        if (!$designation) {
            return $this->errorResponse('Designation not found', 404);
        }
        $userId = $this->checkPermission($request, 94);
        $designation->des_deleted_by = $userId;
        $designation->des_is_deleted = 1;
        $designation->save();

        return response()->json(['message' => 'Designation deleted successfully']);
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
