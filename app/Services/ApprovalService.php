<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\ForApproval;
use App\Models\LeaveApprovalOfficer;
use App\Models\LeaveRequest;
use App\Models\Notification;
use App\Models\PersonalDetails;
use Carbon\Carbon;

class ApprovalService
{

    public function store(array $data){
        $requestId = $data['request_id'];
        $typeId = $data['type_id'];

        try {
            $level = $this->getNextLevel($requestId, $typeId);
            ForApproval::create([
                'request_id'=>$requestId,
                'request_type_id'=>$typeId,
                'level'=>$level,
            ]);
        }catch (CRUDException $e){
            $empId = 0;
            if($typeId == 1){
                $empId = LeaveRequest::find($typeId)->emp_id;
            }

            Notification::create([
                'type_id'=>$typeId,
                'emp_id'=>$empId,
                'message'=>'Your leave request was approved.',
            ]);
            return 'Request was approved.';
        }
    }

    public function approve(int $id, int $officerId, bool $isApproved, ?string $remark, int $requestType){
        if($requestType == 1){
            $approval = ForApproval::find($id);
            $approval->is_approved = $isApproved;
            $approval->is_pending = false;
            $approval->action_by = $officerId;
            $approval->remark = $remark;

            $approval->save();
            if($isApproved){
                $this->store([
                    'request_id'=>$approval->request_id,
                    'type_id'=>1
                ]);
            }
        }
    }

    public function getNextLevel(int $requestId, int $requestType){
        $result = ForApproval::where([
            'request_id'=>$requestId,
            'request_type_id'=>$requestType
        ])->orderBy('created_at', 'desc')
        ->first();
        if($result){
            if($requestType == 1){
                $leaveRequest = LeaveRequest::find($requestId);

                $officer = LeaveApprovalOfficer::where([
                    'emp_id'=> $leaveRequest->emp_id,
                    'level'=>$result['level']+1,
                ])->get();
                if($officer){
                    return $result['level']+1;
                }
                throw new CRUDException('Approval Officer not found in level '.($result['level']+1));
            }
        }
        return 1;
    }

    public function getPreviousApprovals(int $requestId, int $typeId){

        $maxLevel = ForApproval::where([
            'request_id' => $requestId,
            'request_type_id' => $typeId,
        ])->max('level');

        $approvals = ForApproval::where('request_id', $requestId)
            ->where('request_type_id', $typeId)
            ->where('level', '<', $maxLevel)
            ->get();
        if(!$approvals){
            return null;
        }
        foreach ($approvals as $approval){
            $approval['action_by'] = PersonalDetails::find($approval['action_by']);
            $approval['action_on'] = Carbon::parse($approval['updated_at'])->format('F j, Y g:i A');
        }
        return $approvals;

    }

}
