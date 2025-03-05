<?php

namespace App\Services;

use App\Exceptions\CRUDException;
use App\Models\ForApproval;
use App\Models\LeaveApprovalOfficer;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Notification;
use App\Models\PersonalDetails;
use Carbon\Carbon;

class ApprovalService
{
    private NotificationService $notificationService;
    private LeaveBalanceService $leaveBalanceService;
    public function __construct(NotificationService $notificationService, LeaveBalanceService $leaveBalanceService)
    {
        $this->notificationService = $notificationService;
        $this->leaveBalanceService = $leaveBalanceService;
    }

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
            if($typeId == 1){
                $leaveRequest = LeaveRequest::find($requestId);
                $personalDetails = PersonalDetails::find($leaveRequest->emp_id);
                $approvalOfficers = $personalDetails->approvalOfficersByLevel($level);
                $arr = [];
//                return $approvalOfficers;
//                foreach ($approvalOfficers as $officer){
//                    $arr[] = $officer['officer_id'];
//                }
//return $arr;
                return $this->processMail($approvalOfficers, $leaveRequest);
            }
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
    private function processMail($officers, $request){
        $approvals = $this->getPreviousApprovals($request['id'],1);
        $dataSet = [];

        $empData = PersonalDetails::find($request['emp_id']);

        $dataSet['employeeName'] = $empData['full_name'];
        $dataSet['ppno'] = $empData['personal_file_no'];

        if($request['covering_officer_id'] != 0){
            $coveringOfficer = PersonalDetails::find($request['covering_officer_id']);
            $dataSet['coveringOfficer'] = $coveringOfficer['full_name'];
        }else{
            $dataSet['coveringOfficer'] = '--';
        }
        $dataSet['year'] = $request['year'];

        $leaveType = LeaveType::find($request['leave_type_id']);
        $dataSet['requestType'] = 'Leave Request - '.$leaveType['lv_name'];

        $leaveBalances = $this->leaveBalanceService->getAllByEmployeeId($request['emp_id']);
        $dataSet['leaveBalance'] = [];

        foreach ($leaveBalances as $leaveBalance){
            array_push($dataSet['leaveBalance'],[$leaveBalance['lv_name'],$leaveBalance['count'],0]);
        }

        $dataSet['approvalHistory'] = [];
        foreach ($approvals as $approval){
            $dataSet['approvalHistory'] = [$approval['level'],$approval['remark'],$approval['action_by']['full_name'],$approval['action_on'],$approval['is_approved']==1?'Approved':'Reject'];
        }

        foreach ($officers as $officer){
            $data = PersonalDetails::find($officer['officer_id']);
            $dataSet['to'] = $data['personal_email'];
            $this->notificationService->sendMail($dataSet,'leave-request-action', 'Leave Request For Approval');
        }
        return $dataSet;
    }

}
