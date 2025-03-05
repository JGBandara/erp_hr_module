<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\EmployeeCategory;
use App\Services\Interfaces\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeCategoryService implements Service
{
    public function store(array $data): array{
        return EmployeeCategory::create($data)->toArray();
    }

    public function getAll(){
         return EmployeeCategory::where('is_deleted',false)
             ->select([
                 'id',
                 'code',
                 'name',
                 'level',
                 'rank',
                 'remark',
                 'active',
             ])
             ->get();
    }

    public function getAllDetails(int $id){
        return EmployeeCategory::find($id);
    }

    public function update(array $data){
        $category = EmployeeCategory::find($data['id']);
        if (!$category) {
            throw new CRUDException('Category not found');
        }
        $category->update($data);
    }


    public function getById($id)
    {
        return EmployeeCategory::where(['is_deleted'=>false,'id'=>$id])
            ->select([
                'id',
                'code',
                'name',
                'level',
                'rank',
                'remark',
                'active',
            ])
            ->first();
    }

    public function delete($id, $actionBy)
    {
        $category = $this->getById($id)->toArray();
        if(!$category){
            throw new ModelNotFoundException("Category Not found");
        }
        $category['is_deleted'] = true;
        $category['deleted_by'] = $actionBy;
        $this->update($category);
    }
}
