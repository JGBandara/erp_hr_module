<?php

namespace App\Services;

use App\Models\PersonalDetails;

class PersonalDetailsService
{
    public function store(array $personalData): PersonalDetails{
        $data = []; // Initialize the $data array

        if (array_key_exists('personal_file_no', $personalData)) {
            $data['personal_file_no'] = $personalData['personal_file_no'];
        }

        if (array_key_exists('serial_no', $personalData)) {
            $data['serial_no'] = $personalData['serial_no'];
        }

        if (array_key_exists('title', $personalData)) {
            $data['title'] = $personalData['title'];
        }

        if (array_key_exists('initials', $personalData)) {
            $data['initials'] = $personalData['initials'];
        }

        if (array_key_exists('surname', $personalData)) {
            $data['surname'] = $personalData['surname'];
        }

        if (array_key_exists('full_name', $personalData)) {
            $data['full_name'] = $personalData['full_name'];
        }

        if (array_key_exists('nic', $personalData)) {
            $data['nic'] = $personalData['nic'];
        }

        if (array_key_exists('dob', $personalData)) {
            $data['dob'] = $personalData['dob'];
        }

        if (array_key_exists('civil_status', $personalData)) {
            $data['civil_status'] = $personalData['civil_status'];
        }

        if (array_key_exists('gender', $personalData)) {
            $data['gender'] = $personalData['gender'];
        }

        if (array_key_exists('religion', $personalData)) {
            $data['religion'] = $personalData['religion'];
        }


        if (array_key_exists('permanent_address', $personalData)) {
            $data['permanent_address'] = $personalData['permanent_address'];
        }


        if (array_key_exists('mobile', $personalData)) {
            $data['mobile'] = $personalData['mobile'];
        }

        if (array_key_exists('personal_email', $personalData)) {
            $data['personal_email'] = $personalData['personal_email'];
        }

        if (array_key_exists('current_address', $personalData)) {
            $data['current_address'] = $personalData['current_address'];
        }


        if (array_key_exists('residence_phone_number', $personalData)) {
            $data['residence_phone_number'] = $personalData['residence_phone_number'];
        }

        if (array_key_exists('emerg_phone_and_cont_num', $personalData)) {
            $data['emerg_phone_and_cont_num'] = $personalData['emerg_phone_and_cont_num'];
        }

        return PersonalDetails::create($data);
    }

    public function getAllOnlyIdAndFullName(){
         $details = PersonalDetails::all();
         $arr = array();
         foreach ($details as $item){
             array_push($arr, ['id'=>$item->id, 'name'=>$item->full_name]);
         }
         return $arr;
    }
}
