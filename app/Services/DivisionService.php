<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\Division;
use Illuminate\Support\Facades\Http;

class DivisionService
{
    private function createArray(array $arr): array
    {
        $data = []; // Initialize the $data array

        if (array_key_exists('div_code', $arr)) {
            $data['div_code'] = $arr['div_code'];
        }

        if (array_key_exists('div_name', $arr)) {
            $data['div_name'] = $arr['div_name'];
        }

        if (array_key_exists('div_dep_id', $arr)) {
            $data['div_dep_id'] = $arr['div_dep_id'];
        }

        if (array_key_exists('div_head', $arr)) {
            $data['div_head'] = $arr['div_head'];
        }

        if (array_key_exists('div_remark', $arr)) {
            $data['div_remark'] = $arr['div_remark'];
        }

        if (array_key_exists('div_status', $arr)) {
            $data['div_status'] = $arr['div_status'];
        }

        return $data;
    }
    public function store(array $arr): Division{
        return Division::create($this->createArray($arr));
    }

    public function getAll(){
         $details = Division::all();
         $arr = array();
         foreach ($details as $div){
             array_push($arr, ['id'=>$div->id,'div_code'=>$div->div_code, 'div_name'=>$div->div_name]);
         }
         return $arr;
    }

    public function getAllDetails(int $id){
        return Division::find($id);
    }

    public function update(array $arr, int $id, int $modifiedBy){
        $division = Division::find($id);

        if(!$division){
            throw new CRUDException("Division not found");
        }

        if (array_key_exists('div_code', $arr)) {
            $division->div_code = $arr['div_code'];
        }

        if (array_key_exists('div_name', $arr)) {
            $division->div_name = $arr['div_name'];
        }

        if (array_key_exists('div_dep_id', $arr)) {
            $division->div_dep_id = $arr['div_dep_id'];
        }

        if (array_key_exists('div_head', $arr)) {
            $division->div_head = $arr['div_head'];
        }

        if (array_key_exists('div_remark', $arr)) {
            $division->div_remark = $arr['div_remark'];
        }

        if (array_key_exists('div_status', $arr)) {
            $division->div_status = $arr['div_status'];
        }


        $division->div_modified_by = $modifiedBy;

        $division->save();

    }

    public function delete($id){
        $division = Division::find($id);
        if(!$division){
            throw new CRUDException("Division not found");
        }
        $division->div_is_deleted = 1;
        $division->save();
    }


}
