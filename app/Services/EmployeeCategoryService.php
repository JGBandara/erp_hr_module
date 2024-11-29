<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\EmployeeCategory;

class EmployeeCategoryService
{
    private function createArray(array $arr): array
    {
        $data = [];

        if (array_key_exists('emp_cat_code', $arr)) {
            $data['emp_cat_code'] = $arr['emp_cat_code'];
        }

        if (array_key_exists('emp_cat_name', $arr)) {
            $data['emp_cat_name'] = $arr['emp_cat_name'];
        }

        if (array_key_exists('emp_cat_level', $arr)) {
            $data['emp_cat_level'] = $arr['emp_cat_level'];
        }

        if (array_key_exists('emp_cat_rank', $arr)) {
            $data['emp_cat_rank'] = $arr['emp_cat_rank'];
        }

        if (array_key_exists('emp_cat_remark', $arr)) {
            $data['emp_cat_remark'] = $arr['emp_cat_remark'];
        }

        if (array_key_exists('emp_cat_status', $arr)) {
            $data['emp_cat_status'] = $arr['emp_cat_status'];
        }

        return $data;
    }
    public function store(array $arr): EmployeeCategory{
        return EmployeeCategory::create($this->createArray($arr));
    }

    public function getAll(){
         $details = EmployeeCategory::where('emp_cat_is_deleted',0)
             ->select('id','emp_cat_code','emp_cat_name')
             ->get();
         return $details;
    }

    public function getAllDetails(int $id){
        return EmployeeCategory::find($id);
    }

    public function update(array $arr, int $id, int $modifiedBy){

        $category = EmployeeCategory::find($id);

        if (!$category) {
            throw new CRUDException('Category not found');
        }

        if (array_key_exists('emp_cat_code', $arr)) {
            $category->emp_cat_code = $arr['emp_cat_code'];
        }

        if (array_key_exists('emp_cat_name', $arr)) {
            $category->emp_cat_name = $arr['emp_cat_name'];
        }

        if (array_key_exists('emp_cat_level', $arr)) {
            $category->emp_cat_level = $arr['emp_cat_level'];
        }

        if (array_key_exists('emp_cat_rank', $arr)) {
            $category->emp_cat_rank = $arr['emp_cat_rank'];
        }

        if (array_key_exists('emp_cat_remark', $arr)) {
            $category->emp_cat_remark = $arr['emp_cat_remark'];
        }

        if (array_key_exists('emp_cat_status', $arr)) {
            $category->emp_cat_status = $arr['emp_cat_status'];
        }


        $category->emp_cat_modified_by = $modifiedBy;
        $category->save();

    }


}
