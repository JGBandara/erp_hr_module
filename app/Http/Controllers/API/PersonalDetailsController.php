<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonalDetailsRequest;
use App\Models\PersonalDetails;
use App\Services\PersonalDetailsService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PersonalDetailsController extends Controller
{
    use ApiResponse;
    private PersonalDetailsService $personalDetailsService;

    public function __construct(PersonalDetailsService $personalDetailsService){
        $this->personalDetailsService=$personalDetailsService;
    }

    public function store(StorePersonalDetailsRequest $request){
        $validatedData = $request->validated();
        try {
            $data = $this->personalDetailsService->store($validatedData);
            return $this->successResponse($data,'Data saved successful',200);
        }catch (\Exception $e){
            return $this->errorResponse([],[$e->getMessage()]);
        }
    }

    public function getAllForUsers(){
        return $this->personalDetailsService->getAllOnlyIdAndFullName();
    }
    public function getAllDetails(int $id){
        try {
            return $this->successResponse($this->personalDetailsService->getAllDetails($id));
        }catch (\Exception $e){
            return $this->errorResponse();
        }
    }

    public function update(StorePersonalDetailsRequest $request, int $id){

        try{
            $userId =  $this->checkPermission($request, 94);
            $validatedData = $request->validated();
            $this->personalDetailsService->update($validatedData, $id, $userId);
            return $this->successResponse();
        }catch (UnauthorizedException $e){
            return $this->errorResponse([],["You don't have permission to update personal details...!"],401);
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
}
