<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\LeaveRequest;
use App\Models\LeaveType;

class LeaveRequestService
{
    public function store(array $data){
        if($this->checkAvailability($data['emp_id'], $data['leave_type_id'])){
            $data['covering_officer_id'] = 1;
            return LeaveRequest::create($data);
        }
        throw new CRUDException('Leave request store failed.');
    }
    public function checkAvailability(int $empId, int $leaveTypeId):bool{
        $count = LeaveRequest::where([
            ['emp_id', '=', $empId],
            ['leave_type_id', '=', $leaveTypeId],
        ])->count();

        $defaultCount = LeaveType::find($leaveTypeId)->lv_default_count;

        if($count < $defaultCount){
            return true;
        }
        return false;
    }
}
