<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\Department;
use App\Models\Designation;
use App\Services\Interfaces\Service;
use Illuminate\Support\Facades\Http;

class DesignationService implements Service
{
    public function store(array $data) : array{

        $designation = Designation::create($data);
        foreach ($data['departments'] as $depId){
            Designation::find($designation->id)->departments()->attach($depId);
        }
        return $designation->toArray();
    }

    public function update(array $data){
        $designation = Designation::find($data['id']);
        $designation->update($data);
    }

    public function getAll(){
         return Designation::select([
             'id',
             'employee_category_id',
             'code',
             'name',
             'salary_scale_id',
             'ot_allowed',
             'early_ot_allowed',
             'carder',
             'rank',
             'duties',
             'remark',
             'active',
         ])->where('is_deleted',false)->get();
    }

    public function getById($id)
    {
        return Designation::select([
            'id',
            'employee_category_id',
            'code',
            'name',
            'salary_scale_id',
            'ot_allowed',
            'early_ot_allowed',
            'carder',
            'rank',
            'duties',
            'remark',
            'active',
        ])->where(['is_deleted'=>false,'id'=>$id])->first();
    }

    public function delete($id, $actionBy){
        $designation = $this->getById($id)->toArray();
        if(!$designation){
            throw new CRUDException("Designation not found");
        }

        $designation['is_deleted'] = true;
        $designation['des_deleted_by'] = $actionBy;

        $this->update($designation);

    }
}
