<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonalDetailsRequest;
use App\Services\PersonalDetailsService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

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
}
