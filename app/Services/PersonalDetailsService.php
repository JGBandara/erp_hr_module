<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\Department;
use App\Models\Designation;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\PersonalDetails;
use App\Models\ProfilePic;
use Illuminate\Support\Facades\Http;

class PersonalDetailsService
{
    private function createArray(array $arr): array
    {
        $data = [];

        if (array_key_exists('personal_file_no', $arr)) {
            $data['personal_file_no'] = $arr['personal_file_no'];
        }

        if (array_key_exists('serial_no', $arr)) {
            $data['serial_no'] = $arr['serial_no'];
        }

        if (array_key_exists('title', $arr)) {
            $data['title'] = $arr['title'];
        }

        if (array_key_exists('initials', $arr)) {
            $data['initials'] = $arr['initials'];
        }

        if (array_key_exists('surname', $arr)) {
            $data['surname'] = $arr['surname'];
        }

        if (array_key_exists('full_name', $arr)) {
            $data['full_name'] = $arr['full_name'];
        }

        if (array_key_exists('nic', $arr)) {
            $data['nic'] = $arr['nic'];
        }

        if (array_key_exists('dob', $arr)) {
            $data['dob'] = $arr['dob'];
        }

        if (array_key_exists('civil_status', $arr)) {
            $data['civil_status'] = $arr['civil_status'];
        }

        if (array_key_exists('gender', $arr)) {
            $data['gender'] = $arr['gender'];
        }

        if (array_key_exists('religion', $arr)) {
            $data['religion'] = $arr['religion'];
        }


        if (array_key_exists('permanent_address', $arr)) {
            $data['permanent_address'] = $arr['permanent_address'];
        }


        if (array_key_exists('mobile', $arr)) {
            $data['mobile'] = $arr['mobile'];
        }

        if (array_key_exists('personal_email', $arr)) {
            $data['personal_email'] = $arr['personal_email'];
        }

        if (array_key_exists('current_address', $arr)) {
            $data['current_address'] = $arr['current_address'];
        }


        if (array_key_exists('residence_phone_number', $arr)) {
            $data['residence_phone_number'] = $arr['residence_phone_number'];
        }

        if (array_key_exists('emerg_phone_and_cont_num', $arr)) {
            $data['emerg_phone_and_cont_num'] = $arr['emerg_phone_and_cont_num'];
        }

        return $data;
    }

    public function store(array $arr): PersonalDetails
    {
        return PersonalDetails::create($this->createArray($arr));
    }

    public function updateImgKey(int $empId, string $key)
    {
        $pic = ProfilePic::where('emp_id', $empId)->firstOr(function () use ($empId, $key) {
            return ProfilePic::create([
                'emp_id' => $empId,
                'img_key' => $key,
            ]);
        });

        $pic->img_key = $key;
        $pic->save();
    }


    public function getAllOnlyIdAndFullName()
    {
        $response = Http::get('http://localhost:8001/api/user/all');
        $arr = [];
        if($response['data']){
            foreach ($response['data'] as $user){
                $arr[] = $user['emp_id'];
            }
        }

        $details = PersonalDetails::whereNotIn('id',$arr)->get();
        $arr = array();
        foreach ($details as $item) {
            array_push($arr, ['id' => $item->id, 'name' => $item->full_name]);
        }
        return $arr;
    }

    public function getAll()
    {
        return PersonalDetails::all();
    }

    public function getAllDetails(int $id)
    {
        $data = PersonalDetails::find($id);
        $data['img_key'] = $data->profilePic->img_key;

        $designation = $data->lastDesignation();

        $data['designation'] = [
            'id' => $designation ? $designation->designation_id : null,
            'name' => $designation ? Designation::find($designation->designation_id)['des_name'] : null,
        ];

        $department = $designation ? Department::find($designation->department_id) : null;

        $data['department'] = [
            'id' => $department ? $department->id : null,
            'code' => $department ? $department->dep_code : null,
            'name' => $department ? $department->dep_name : null,
        ];
        return $data;
    }

    public function update(array $arr, int $id, int $modifiedBy)
    {
        $personalDetails = PersonalDetails::find($id);

        if (array_key_exists('personal_file_no', $arr)) {
            $personalDetails->personal_file_no = $arr['personal_file_no'];
        }

        if (array_key_exists('serial_no', $arr)) {
            $personalDetails->serial_no = $arr['serial_no'];
        }

        if (array_key_exists('title', $arr)) {
            $personalDetails->title = $arr['title'];
        }

        if (array_key_exists('initials', $arr)) {
            $personalDetails->initials = $arr['initials'];
        }

        if (array_key_exists('surname', $arr)) {
            $personalDetails->surname = $arr['surname'];
        }

        if (array_key_exists('full_name', $arr)) {
            $personalDetails->full_name = $arr['full_name'];
        }

        if (array_key_exists('nic', $arr)) {
            $personalDetails->nic = $arr['nic'];
        }

        if (array_key_exists('dob', $arr)) {
            $personalDetails->dob = $arr['dob'];
        }

        if (array_key_exists('civil_status', $arr)) {
            $personalDetails->civil_status = $arr['civil_status'];
        }

        if (array_key_exists('gender', $arr)) {
            $personalDetails->gender = $arr['gender'];
        }

        if (array_key_exists('religion', $arr)) {
            $personalDetails->religion = $arr['religion'];
        }

        if (array_key_exists('permanent_address', $arr)) {
            $personalDetails->permanent_address = $arr['permanent_address'];
        }

        if (array_key_exists('mobile', $arr)) {
            $personalDetails->mobile = $arr['mobile'];
        }

        if (array_key_exists('personal_email', $arr)) {
            $personalDetails->personal_email = $arr['personal_email'];
        }

        if (array_key_exists('current_address', $arr)) {
            $personalDetails->current_address = $arr['current_address'];
        }

        if (array_key_exists('residence_phone_number', $arr)) {
            $personalDetails->residence_phone_number = $arr['residence_phone_number'];
        }

        if (array_key_exists('emerg_phone_and_cont_num', $arr)) {
            $personalDetails->emerg_phone_and_cont_num = $arr['emerg_phone_and_cont_num'];
        }

        $personalDetails->modified_by = $modifiedBy;

        return $personalDetails->save();

    }

    public function getAllHistory(int $empId)
    {
        return PersonalDetails::find($empId)->history;
    }

    public function getDetailsByEmpNo(string $no)
    {
        return PersonalDetails::where('personal_file_no', $no)->firstOr(function () {
            throw new CRUDException('Invalid Number');
        });
    }

    public function getAllAssignedForApproval($id)
    {
        $array = [];
        foreach (PersonalDetails::find($id)->assignedEmployees as $item) {
            foreach ($this->getRequests($item['emp_id']) as $request) {
                $array[] = $request;
            }
        }
        $approvals = [];
        foreach ($array as $request) {
            foreach ($this->getApprovals($request['id']) as $approval) {
                if($this->checkLevel($approval['level'], $request['emp_id'], $id)){
                    $approvals[] = $this->createApprovalObject($approval);
                }
            }
        }
        return $approvals;
    }

    private function createApprovalObject($approval){
        $approval['request']=LeaveRequest::find($approval['request_id']);
        $approval['employee'] = PersonalDetails::find($approval['request']['emp_id']);
        $approval['request']['leave_type']=LeaveType::find($approval['request']['leave_type_id']);
        return $approval;
    }

    public function getRequests($id)
    {
        return PersonalDetails::find($id)->leaveRequests;
    }

    public function getApprovals($requestId)
    {
        return LeaveRequest::find($requestId)->approvals;
    }

    private function checkLevel($level, $empId, $officerId)
    {
        foreach (PersonalDetails::find($empId)->approvalOfficersByLevel($level) as $officer) {
            if ($officer['officer_id'] == $officerId) {
                return true;
            }
        }
        return false;
    }

    private function putInARow(array $data)
    {
        return $this->createSingleArray($data, []);
    }

    private function createSingleArray(array $data, array $new)
    {
        foreach ($data as $item) {
            if (is_array($item)) {
                $new = $this->createSingleArray($item, $new);
            } else {
                $new[] = $item;
            }
        }
        return $new;
    }

    private function removeDuplicates(array $array, string $key = null)
    {
        return collect($array)->unique($key)->values()->all();
    }
}
