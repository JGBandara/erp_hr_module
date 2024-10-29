<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQualificationRequest;
use App\Services\QualificationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    use ApiResponse;
    private QualificationService $qualificationService;
    public function __construct(QualificationService $qualificationService)
    {
       $this->qualificationService = $qualificationService;
    }

    public function storeOL(StoreQualificationRequest $request){
        $validatedData = $request->validated();

        return $this->successResponse($this->qualificationService->storeOL($validatedData));
    }
    public function getOLResults(int $id){
        return $this->successResponse($this->qualificationService->getOLResults($id));
    }
    public function storeAL(StoreQualificationRequest $request){
        $validatedData = $request->validated();
        return $this->successResponse($this->qualificationService->storeAL($validatedData));
    }

    public function getALResults(int $id){
        return $this->successResponse($this->qualificationService->getALResults($id));
    }
    public function storeProfessionalQualifications(StoreQualificationRequest $request){
        $validatedData = $request->validated();
        return $this->successResponse($this->qualificationService->storeProfessionQualification($validatedData));
    }
    public function getProfessionalQualifications(int $id){
        return $this->successResponse($this->qualificationService->getProfessionalQualifications($id));
    }
}
