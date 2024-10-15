<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Models\EducationQualification; 
use App\Http\Requests\StoreEducationQualificationRequest;
use Illuminate\Http\Request;
use App\Services\EducationQualificationService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;

class EducationQualificationController extends Controller
    {
        use ApiResponse;
        private EducationQualificationService $educationQualificationService;

    public function __construct(EducationQualificationService $educationQualificationService){
        $this->educationQualificationService=$educationQualificationService;
    }
            public function index()
            {
                return $this->educationQualificationService->getAll();
            }
        
            public function getAllDetails(int $id)
            {
                try {
                    return $this->successResponse($this->educationQualificationService->getAllDetails($id));
                }catch (\Exception $e){
                    return $this->errorResponse();
                }
            }
        
            public function store(StoreEducationQualificationRequest $request)
            {
                $validatedData = $request->validated();
                try {
                    $data = $this->educationQualificationService->store($validatedData);
                    return $this->successResponse($data,'Data saved successful',200);
                }catch (\Exception $e){
                    return $this->errorResponse([],[$e->getMessage()]);
                }
            }
        
            public function update(StoreEducationQualificationRequest $request, $id)
            {
                try{
                    $userId =  $this->checkPermission($request, 94);
                    $validatedData = $request->validated();
                    $this->educationQualificationService->update($validatedData, $id, $userId);
                    return $this->successResponse();
                }catch (UnauthorizedException $e){
                    return $this->errorResponse([],["You don't have permission to update Education Details...!"],401);
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
                 $educationQualification = EducationQualification::find($id);
                if (!$educationQualification) {
                    return $this->errorResponse('Qualification not found', 404);
                }
                $userId = $this->checkPermission($request, 94);
                $educationQualification->qua_deleted_by = $userId;
                $educationQualification->qua_is_deleted = 1;
                $educationQualification->save();
        
                return response()->json(['message' => 'Qualification deleted successfully']);
         
            }
        }
        