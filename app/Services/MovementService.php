<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\Movement;
use App\Models\PersonalDetails;

class MovementService
{
    private function createArray(array $arr):array{
        $data = [];
        if(array_key_exists('EMP ID', $arr)){
            $data['emp_id'] = $arr['EMP ID'];
        }
        if(array_key_exists('Out Date', $arr) && array_key_exists('Out Time',$arr)){
            $data['out_datetime'] = $arr['Out Date'].' '.$arr['Out Time'];
        }
        if(array_key_exists('In Date', $arr) && array_key_exists('In Time',$arr)){
            $data['in_datetime'] = $arr['In Date'].' '.$arr['In Time'];
        }
        if(array_key_exists('In Location', $arr)){
            $data['in_location'] = $arr['In Location'];
        }
        if(array_key_exists('Out Location', $arr)){
            $data['out_location'] = $arr['Out Location'];
        }
        if(array_key_exists('Reason', $arr)){
            $data['reason'] = $arr['Reason'];
        }
        return $data;
    }
    public function store(array $data){
        $arr = array_map([$this, 'createArray'], $data);
        foreach ($arr as $item){
            $ppData = PersonalDetails::where('personal_file_no',$item['emp_id'])->firstOr(function(){
                throw new CRUDException("Invalid Employee Id Contains.");
            });
            $item['emp_id'] = $ppData->id;
            Movement::create($item);
        }
    }
    public function getBelonsTo($id){
        $arr = [];
        foreach (PersonalDetails::find($id)->movements as $movement){
            $empId = $movement['emp_id'];
            $arr[] = [
                'emp_id'=>$empId,
                'emp_no'=>PersonalDetails::find($empId)->personal_file_no,
                'out_datetime'=>$movement['out_datetime'],
                'out_location'=>$movement['out_location'],
                'in_datetime'=>$movement['in_datetime'],
                'in_location'=>$movement['in_location'],
                'reason'=>$movement['reason'],

            ];
        }
        return $arr;
        return PersonalDetails::find($id)->movements;
    }
}
