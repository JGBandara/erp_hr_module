<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\Division;
use App\Services\Interfaces\Service;
use Illuminate\Support\Facades\Http;

class DivisionService implements Service
{
    public function store(array $data): array
    {
        return Division::create($data)->toArray();
    }

    public function update(array $data)
    {
        $division = Division::find($data['id']);
        if (!$division) {
            throw new CRUDException("Division not found");
        }
        $division->update($data);
    }

    public function getAll()
    {
        $details = Division::select([
            'id',
            'code',
            'name',
            'department_id',
            'head_of_department_id',
            'remark',
        ])->where('is_deleted', false)->get();
        return $details;
    }

    public function getById($id)
    {
        return Division::select(
            [
                'id',
                'code',
                'name',
                'department_id',
                'head_of_department_id',
                'remark',
            ]
        )->where(['is_deleted' => false, 'id' => $id])->first();
    }

    public function delete($id, $actionBy)
    {
        $division = $this->getById($id)->toArray();
        if (!$division) {
            throw new CRUDException("Division not found");
        }
        $division['is_deleted'] = true;
        $division['deleted_by'] = $actionBy;
        $this->update($division);
    }
}
