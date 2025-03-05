<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\educationQualification;
use App\Services\Interfaces\Service;
use Illuminate\Support\Facades\Http;

class EducationQualificationService implements Service
{
    public function store(array $data): array
    {
        return EducationQualification::create($data)->toArray();
    }
    public function update(array $data)
    {
        $educationQualification = EducationQualification::find($data['id']);

        if (!$educationQualification) {
            throw new CRUDException("Education Qualification not found");
        }

        $educationQualification->update($data);
    }

    public function getAll()
    {
        return EducationQualification::select([
            'id',
            'name',
            'remark',
            'active',
        ])->where('is_deleted', false)->get();
    }

    public function getById($id)
    {
        return EducationQualification::select([
            'id',
            'name',
            'remark',
            'active',
        ])->where(['is_deleted' => false, 'id' => $id])->first();
    }

    public function delete($id, $actionBy)
    {
        $educationQualification = $this->getById($id)->toArray();
        if (!$educationQualification) {
            throw new CRUDException('Qualification not found');
        }
        $educationQualification['deleted_by'] = $actionBy;
        $educationQualification['is_deleted'] = true;
        $this->update($educationQualification);
    }
}
