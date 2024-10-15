<?php

namespace App\Services;

use App\Models\Designation;
use Illuminate\Support\Facades\Http;

class DesignationService
{
    private function createArray(array $arr): array
    {
        $data = []; // Initialize the $data array

        if (array_key_exists('des_code', $arr)) {
            $data['des_code'] = $arr['des_code'];
        }

        if (array_key_exists('des_name', $arr)) {
            $data['des_name'] = $arr['des_name'];
        }

        if (array_key_exists('des_salary_scale_id', $arr)) {
            $data['des_salary_scale_id'] = $arr['des_salary_scale_id'];
        }

        if (array_key_exists('des_ot_allowed', $arr)) {
            $data['des_ot_allowed'] = $arr['des_ot_allowed'];
        }
        if (array_key_exists('des_early_ot_allowed', $arr)) {
            $data['des_early_ot_allowed'] = $arr['des_early_ot_allowed'];
        }

        if (array_key_exists('des_carder', $arr)) {
            $data['des_carder'] = $arr['des_carder'];
        }

        if (array_key_exists('des_rank', $arr)) {
            $data['des_rank'] = $arr['des_rank'];
        }

        if (array_key_exists('des_dep_id', $arr)) {
            $data['des_dep_id'] = $arr['des_dep_id'];
        }
        if (array_key_exists('des_duties', $arr)) {
            $data['des_duties'] = $arr['des_duties'];
        }
        if (array_key_exists('des_remark', $arr)) {
            $data['des_remark'] = $arr['des_remark'];
        }

        if (array_key_exists('des_status', $arr)) {
            $data['des_status'] = $arr['des_status'];
        }

        return $data;
    }
    public function store(array $arr): Designation{
        return Designation::create($this->createArray($arr));
    }

    public function getAll(){
         $details = Designation::all();
         $arr = array();
         foreach ($details as $des){
             array_push($arr, ['id'=>$des->id,'des_code'=>$des->des_code, 'des_name'=>$des->des_name]);
         }
         return $arr;
    }

    public function getAllDetails(int $id){
        return Designation::find($id);
    }

    public function update(array $arr, int $id, int $modifiedBy){
        $designation = Designation::find($id);

       
        if (array_key_exists('des_code', $arr)) {
            $data['des_code'] = $arr['des_code'];
        }

        if (array_key_exists('des_name', $arr)) {
            $data['des_name'] = $arr['des_name'];
        }

        if (array_key_exists('des_salary_scale_id', $arr)) {
            $data['des_salary_scale_id'] = $arr['des_salary_scale_id'];
        }

        if (array_key_exists('des_ot_allowed', $arr)) {
            $data['des_ot_allowed'] = $arr['des_ot_allowed'];
        }
        if (array_key_exists('des_early_ot_allowed', $arr)) {
            $data['des_early_ot_allowed'] = $arr['des_early_ot_allowed'];
        }

        if (array_key_exists('des_carder', $arr)) {
            $data['des_carder'] = $arr['des_carder'];
        }

        if (array_key_exists('des_rank', $arr)) {
            $data['des_rank'] = $arr['des_rank'];
        }

        if (array_key_exists('des_dep_id', $arr)) {
            $data['des_dep_id'] = $arr['des_dep_id'];
        }
        if (array_key_exists('des_duties', $arr)) {
            $data['des_duties'] = $arr['des_duties'];
        }
        if (array_key_exists('des_remark', $arr)) {
            $data['des_remark'] = $arr['des_remark'];
        }

        if (array_key_exists('des_status', $arr)) {
            $data['des_status'] = $arr['des_status'];
        }


        $designation->des_modified_by = $modifiedBy;

        $designation->save();

    }


}
