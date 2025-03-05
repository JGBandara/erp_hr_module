<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Exceptions\DepartmentNotFoundException;
use App\Models\Department;
use App\Services\abstract\CrudService;
use App\Services\Interfaces\Service;
use Illuminate\Database\Eloquent\Model;

class DepartmentService extends CrudService
{
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

//    public function store(array $data):array{
//       return Department::create($data)->toArray();
//    }
//    public function update(array $data){
//        $department = Department::find($data['id']);
//        if (!$department) {
//            throw new DepartmentNotFoundException("Department not found");
//        }
//
//        try {
//            $department->update($data);
//            return $department;
//        } catch (\Exception $e) {
//            throw new CRUDException("Update not successful");
//        }
//
//    }
//    public function getAll(){
//        return Department::where('is_deleted', 0)->select('id','code', 'name', 'remark','active')->get();
//    }
//
//    public function getById($id)
//    {
//        return Department::select([
//            'id',
//            'name',
//            'code',
//            'remark',
//            'active'
//        ])->where(['is_deleted'=>false, 'id'=>$id])->first();
//    }
//    public function delete($id, $actionBy){
//        $department = $this->getById($id);
//        if (!$department) {
//            throw new DepartmentNotFoundException("Department not found");
//        }
//        $department['is_deleted'] = true;
//        $this->update($department);
//    }
}
