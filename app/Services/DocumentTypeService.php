<?php

namespace App\Services;

use App\Models\DocumentType;
use App\Services\Interfaces\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DocumentTypeService implements Service
{
    public function store(array $data):array
    {
        return DocumentType::create($data);
    }

    public function update(array $data)
    {
        $documentType = DocumentType::findOrFail($data['id']);
        $documentType->save($data);
    }

    public function getAll()
    {
        return DocumentType::select([
            'type',
            'remark',
        ])->where('is_deleted',false)->get();
    }

    public function getById($id)
    {
        return DocumentType::select([
            'type',
            'remark',
        ])->where(['is_deleted'=>false,'id'=>$id])->first();
    }

    public function delete($id, $actionBy)
    {
        $documentTypes = $this->getById($id);
        if(!$documentTypes){
            throw new ModelNotFoundException("Document Type not found");
        }
        $documentTypes['deleted_by'] = $actionBy;
        $documentTypes['is_deleted'] = true;
        $this->update($documentTypes);
    }
}
