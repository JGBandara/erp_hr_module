<?php

namespace App\Services;

use App\Models\ResignType;
use Illuminate\Support\Facades\Http;

class ResignTypeService
{
    private function createArray(array $arr): array
    {
        $data = [];

        
        if (array_key_exists('rsg_name', $arr)) {
            $data['rsg_name'] = $arr['rsg_name'];
        }

        if (array_key_exists('rsg_remarks', $arr)) {
            $data['rsg_remarks'] = $arr['rsg_remarks'];
        }

        if (array_key_exists('rsg_status', $arr)) {
            $data['rsg_status'] = $arr['rsg_status'];
        }

        return $data;
    }
    public function store(array $arr): ResignType{
        return ResignType::create($this->createArray($arr));
    }

    public function getAll(){
         $details = ResignType::all();
         $arr = array();
         foreach ($details as $type){
             array_push($arr, ['id'=>$type->id, 'rsg_name'=>$type->rsg_name]);
         }
         return $arr;
    }

    public function getAllDetails(int $id){
        return ResignType::find($id);
    }

    public function update(array $arr, int $id, int $modifiedBy){
        $resignType = ResignType::find($id);

        
        if (array_key_exists('rsg_name', $arr)) {
            $resignType->rsg_name = $arr['rsg_name'];
        }

        if (array_key_exists('rsg_remarks', $arr)) {
            $resignType->rsg_remarks = $arr['rsg_remarks'];
        }

        if (array_key_exists('rsg_status', $arr)) {
            $resignType->rsg_status = $arr['rsg_status'];
        }


        $resignType->rsg_modified_by = $modifiedBy;

        $resignType->save();

    }


}
