<?php

namespace App\Services;

use App\Models\LeaveType;
use Illuminate\Support\Facades\Http;

class LeaveTypeService
{
    private function createArray(array $arr): array
    {
        $data = [];

        if (array_key_exists('lv_code', $arr)) {
            $data['lv_code'] = $arr['lv_code'];
        }

        if (array_key_exists('lv_name', $arr)) {
            $data['lv_name'] = $arr['lv_name'];
        }

        if (array_key_exists('lv_salary_deduct', $arr)) {
            $data['lv_salary_deduct'] = $arr['lv_salary_deduct'];
        }

        if (array_key_exists('lv_count_working_days', $arr)) {
            $data['lv_count_working_days'] = $arr['lv_count_working_days'];
        }

        if (array_key_exists('lv_default_count', $arr)) {
            $data['lv_default_count'] = $arr['lv_default_count'];
        }

        if (array_key_exists('lv_has_limit', $arr)) {
            $data['lv_has_limit'] = $arr['lv_has_limit'];
        }
        if (array_key_exists('lv_allow_attendance_bonus', $arr)) {
            $data['lv_allow_attendance_bonus'] = $arr['lv_allow_attendance_bonus'];
        }
        if (array_key_exists('lv_remark', $arr)) {
            $data['lv_remark'] = $arr['lv_remark'];
        }

        if (array_key_exists('lv_status', $arr)) {
            $data['lv_status'] = $arr['lv_status'];
        }

        return $data;
    }
    public function store(array $arr): LeaveType{
        return LeaveType::create($this->createArray($arr));
    }

    public function getAll(){
         $details = LeaveType::all();
         $arr = array();
         foreach ($details as $type){
             array_push($arr, ['id'=>$type->id,'lv_code'=>$type->lv_code, 'lv_name'=>$type->lv_name]);
         }
         return $arr;
    }

    public function getAllDetails(int $id){
        return LeaveType::find($id);
    }

    public function update(array $arr, int $id, int $modifiedBy){
        $LeaveType = LeaveType::find($id);

        if (array_key_exists('lv_code', $arr)) {
            $LeaveType->lv_code = $arr['lv_code'];
        }

        if (array_key_exists('lv_name', $arr)) {
            $LeaveType->lv_name = $arr['lv_name'];
        }

        if (array_key_exists('lv_salary_deduct', $arr)) {
            $LeaveType->lv_salary_deduct = $arr['lv_salary_deduct'];
        }

        if (array_key_exists('lv_count_working_days', $arr)) {
            $LeaveType->lv_count_working_days = $arr['lv_count_working_days'];
        }

        if (array_key_exists('lv_remark', $arr)) {
            $LeaveType->lv_remark = $arr['lv_remark'];
        }

        if (array_key_exists('lv_status', $arr)) {
            $LeaveType->lv_status = $arr['lv_status'];
        }


        $LeaveType->modified_by = $modifiedBy;

        $LeaveType->save();

    }


}
