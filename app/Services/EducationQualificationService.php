<?php

namespace App\Services;

use App\Models\educationQualification;
use Illuminate\Support\Facades\Http;

class EducationQualificationService
{
    private function createArray(array $arr): array
    {
        $data = [];

        
        if (array_key_exists('qua_name', $arr)) {
            $data['qua_name'] = $arr['qua_name'];
        }

        if (array_key_exists('qua_remark', $arr)) {
            $data['qua_remark'] = $arr['qua_remark'];
        }

        if (array_key_exists('qua_status', $arr)) {
            $data['qua_status'] = $arr['qua_status'];
        }

        return $data;
    }
    public function store(array $arr): educationQualification{
        return educationQualification::create($this->createArray($arr));
    }

    public function getAll(){
         $details = educationQualification::all();
         $arr = array();
         foreach ($details as $type){
             array_push($arr, ['id'=>$type->id, 'qua_name'=>$type->qua_name]);
         }
         return $arr;
    }

    public function getAllDetails(int $id){
        return educationQualification::find($id);
    }

    public function update(array $arr, int $id, int $modifiedBy){
        $educationQualification = educationQualification::find($id);

        
        if (array_key_exists('qua_name', $arr)) {
            $educationQualification->qua_name = $arr['qua_name'];
        }

        if (array_key_exists('qua_remark', $arr)) {
            $educationQualification->qua_remark = $arr['qua_remark'];
        }

        if (array_key_exists('qua_status', $arr)) {
            $educationQualification->qua_status = $arr['qua_status'];
        }


        $educationQualification->qua_modified_by = $modifiedBy;

        $educationQualification->save();

    }


}
