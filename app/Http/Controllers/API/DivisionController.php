<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDivisionRequest;
use App\Models\Division; 
use Illuminate\Http\Request;
use App\Services\DivisionService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DivisionController extends Controller
{
        use ApiResponse;
        private DivisionService $divisionService;

        public function __construct(DivisionService $divisionService){
            $this->divisionService = $divisionService;
        }

            public function index()
            {
                return $this->divisionService->getAll();
            }
        
            public function store(StoreDivisionRequest $request){
                $validatedData = $request->validated();
                try {
              
                    $data = $this->divisionService->store($validatedData);
                    return $this->successResponse($data, 'Data Saved Successfully', 200);
                } catch (\Exception $e) {
                    return $this->errorResponse([],[$e->getMessage()]);
                }
            }
            public function getAllDetails(int $id){
                try {
                    return $this->successResponse($this->divisionService->getAllDetails($id));
                }catch (\Exception $e){
                    return $this->errorResponse();
                }
            }
            public function update(StoreDivisionRequest $request, $id) {
                try {
                    // Log the incoming request data
                    Log::info('Update Request Data: ', $request->all());
            
                    $userId = $this->checkPermission($request, 94);
                    $validatedData = $request->validated();
                    
                    // Check the structure of validatedData
                    Log::info('Validated Data: ', $validatedData);
                    
                    $this->divisionService->update($validatedData, $id, $userId);
                    return $this->successResponse();
                } catch (UnauthorizedException $e) {
                    return $this->errorResponse([], ["You don't have permission to update Division ...!"], 401);
                } catch (\Exception $e) {
                    return $this->errorResponse([], $e->getMessage());
                }
            }
            
    
           
        public function destroy($id)
            {
                $division = Division::find($id);
                if (!$division) {
                    return $this->errorResponse('Division not found', 404);
                }
        
                $division->div_is_deleted = 1;
                $division->save();
        
                return response()->json(['message' => 'Division deleted successfully']);
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
        