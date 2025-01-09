<?php

namespace App\Services;

use App\Models\LeaveApprovalOfficer;
use App\Models\PersonalDetails;

class LeaveApprovalOfficerService
{
    public function store(array $data){
        $empId =  $data['emp_id'];
        $this->deleteAll($empId);
        foreach ($data['officers'] as $key => $officer){
            $level = explode('_',$key)[1];
            foreach ($officer as $each){
                LeaveApprovalOfficer::create([
                    'emp_id'=>$empId,
                    'officer_id'=>$each,
                    'level'=>$level,
                    'created_by'=>$data['user_id']
                ]);
            }
        }
    }
    public function getAppravalOfficersByEmpIdAndLevel(int $empId, int $level){
        return PersonalDetails::find($empId)->approvalOfficersByLevel($level);
    }
    public function deleteAll(int $empId){
        LeaveApprovalOfficer::where('emp_id',$empId)->delete();
    }

}
