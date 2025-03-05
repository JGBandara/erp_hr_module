<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\BaseController;
use App\Http\Requests\StoreDocumentTypeRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Services\DocumentTypeService;
use App\Services\Util\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    use ApiResponse;
    private DocumentTypeService $documentTypeService;
    public function __construct(DocumentTypeService $documentTypeService)
    {
        $this->documentTypeService = $documentTypeService;
    }

    public function store(StoreDocumentTypeRequest $request)
    {
        $validatedData = $request->validated();
        $userId = AuthService::getAuthUser($request)['id'];
        $validatedData['created_by'] = $userId;
        return $this->successResponse($this->documentTypeService->store($validatedData));
    }

    public function update(UpdateDepartmentRequest $request)
    {
        $validatedData = $request->validated();
        return $this->successResponse($this->documentTypeService->update($validatedData));
    }

    public function delete(Request $request, $id)
    {
        if(!AuthService::checkPermission($request,'remove','human-resource/master-data/document-type/add-new')){
            return $this->errorResponse('Unauthorized',[], 401);
        }
        $userId = AuthService::getAuthUser($request)['id'];
        $this->documentTypeService->delete($id,$userId);
        return $this->successResponse();
    }

    public function getAll(Request $request)
    {
        return $this->successResponse($this->documentTypeService->getAll());
    }

    public function getById($id)
    {
       return $this->successResponse($this->documentTypeService->getById($id));
    }
}
