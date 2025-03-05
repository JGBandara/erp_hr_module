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
        if (array_key_exists('lv_remarks', $arr)) {
            $data['lv_remarks'] = $arr['lv_remarks'];
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
         $details = LeaveType::select([
             'id',
             'lv_name',
             'lv_code',
             'lv_default_count',
         ])->where('lv_is_deleted',false)->get();
         return $details;
    }

    public function getAllDetails(int $id){
        return LeaveType::find($id);
    }

    public function update(array $arr, int $id, int $modifiedBy){
        $LeaveType = LeaveType::find($id);


        if (array_key_exists('lv_name', $arr)) {
            $LeaveType->lv_name = $arr['lv_name'];
        }

        if (array_key_exists('lv_salary_deduct', $arr)) {
            $LeaveType->lv_salary_deduct = $arr['lv_salary_deduct'];
        }

        if (array_key_exists('lv_count_working_days', $arr)) {
            $LeaveType->lv_count_working_days = $arr['lv_count_working_days'];
        }

        if (array_key_exists('lv_remarks', $arr)) {
            $LeaveType->lv_remarks = $arr['lv_remarks'];
        }

        if (array_key_exists('lv_status', $arr)) {
            $LeaveType->lv_status = $arr['lv_status'];
        }


        $LeaveType->lv_modified_by = $modifiedBy;

        $LeaveType->save();

    }

    public function destroy(array $arr, int $id, int $deletedBy){
        $LeaveType = LeaveType::find($id);

        $LeaveType->deleted_by = $deletedBy;

        $LeaveType->save();

    }


}
