<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\PersonalDetails;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LeaveBalanceService
{
    public function store(array $data)
    {
        foreach ($data['data'] as $each){
            if($this->getDefault($each['lv_name'])!=$each['count']){
                try {
                    $leaveType = LeaveType::where('lv_name',$each['lv_name'])->first();
                    $leaveBalance = $this->getByLeaveTypeAndEmployeeId($leaveType->id, $data['emp_id']);
                    return $this->update(LeaveBalance::find($leaveBalance['id']), $each);
                } catch (CRUDException $e) {
                    $each['leave_type_id'] = LeaveType::where('lv_name',$each['lv_name'])->first()->id;
                    $each['emp_id'] = $data['emp_id'];
                    $each['location_id'] = $data['location_id'];
                    $each['created_by'] = $data['created_by'];
                    LeaveBalance::create($each);
                }
            }
        }
    }

    public function getByLeaveTypeAndEmployeeId(int $leaveTypeId, int $empId)
    {
        $leaveBalance = LeaveBalance::where(['leave_type_id' => $leaveTypeId, 'emp_id' => $empId])->firstOr(function () {
            throw new CRUDException('Leave Balance not found');
        });
        return $leaveBalance;
    }

    public function update(LeaveBalance $leaveBalance, array $values)
    {
        foreach ($values as $key => $value) {
            if ($leaveBalance->isFillable($key)) {
                $leaveBalance->$key = $value;
            }
        }
        $leaveBalance->save();
    }

    public function getAllByEmployeeId(int $empId)
    {
        $special = PersonalDetails::find($empId)->leaveBalance;
        $exceptIds = [];
        foreach ($special as $each) {
            $exceptIds[] = $each->leave_type_id;
        }
        $defaults = LeaveType::whereNotIn('id', $exceptIds)->select(['lv_name', 'lv_code', DB::raw('lv_default_count AS count')])->get();
        foreach ($exceptIds as $id) {
            foreach ($special as $each) {
                if ($id == $each->leave_type_id) {
                    $leaveType = LeaveType::find($id);
                    $defaults[] = [
                        'lv_name' => $leaveType->lv_name,
                        'lv_code' => $leaveType->lv_code,
                        'count' => $each->count
                    ];
                }
            }
        }
        return array_values(Arr::sort($defaults,function($value){
            return $value['lv_code'];
        }));
    }
    private function getDefault(string $leaveType){
        return LeaveType::where('lv_name',$leaveType)->first()->lv_default_count;
    }

}
