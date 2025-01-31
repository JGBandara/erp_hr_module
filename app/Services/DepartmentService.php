<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Exceptions\DepartmentNotFoundException;
use App\Models\Department;

class DepartmentService
{

    public function store(array $validatedData){
        $data = [
            'dep_code' => $validatedData['department_code'],
            'dep_name' => $validatedData['department_name'],
            'dep_remark' => $validatedData['remark'] ?? null,
            'dep_status' => $validatedData['active'],
        ];
        $department = Department::create($data);

        return $department;
    }
    public function update(int $id, array $validatedData){
        $department = Department::find($id);
        if (!$department) {
            throw new DepartmentNotFoundException("Department not found");
        }

        $department->dep_code = $validatedData['department_code'];
        $department->dep_name = $validatedData['department_name'];
        $department->dep_remark = $validatedData['remark'] ?? null;
        $department->dep_status = $validatedData['active'] ? 1 : 0; // Convert boolean to integer (1 or 0)

        try {
            $department->save();
            return $department;
        } catch (\Exception $e) {
//            Log::error('Error updating department', ['error' => $e->getMessage()]);
            throw new CRUDException("Update not successful");
        }

    }
    public function getAll(){
        return Department::where('dep_is_deleted', 0)->select('id','dep_code', 'dep_name', 'dep_remark', 'dep_status')->get();
    }

    public function delete($id){
        $department = Department::find($id);
        if (!$department) {
            throw new DepartmentNotFoundException("Department not found");
        }
        $department->dep_is_deleted = 1;
        $department->save();
    }

}
