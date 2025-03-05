<?php

namespace App\Services;

use App\Exceptions\ExceedLeaveLimitException;
use App\Exceptions\IllegalArgumentException;
use App\Exceptions\UnauthorizedException;
use App\Mail\CoveringOfficerActionMail;
use App\Models\ForApproval;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestAttachments;
use App\Models\LeaveType;
use App\Models\PersonalDetails;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class LeaveRequestService
{
    private ApprovalService $approvalService;
    private NotificationService $notificationService;

    public function __construct(ApprovalService $approvalService, NotificationService $notificationService)
    {
        $this->approvalService = $approvalService;
        $this->notificationService = $notificationService;
    }

    /**
     * @throws IllegalArgumentException
     * @throws ExceedLeaveLimitException
     */
    public function store(array $data)
    {
        if($this->isCoveringOfficerAvailbale($data['date_from'], $data['date_to'],$data['covering_officer_id'])){

            if ($this->confirmDaysCount($data['date_from'], $data['date_to']) == $data['no_of_days']) {

                if ($this->checkAvailability($data['emp_id'], $data['leave_type_id'], $data['year'], $data['no_of_days'])) {


                    $data['request_no'] = $this->genarateLeaveRequestNumber();

                    $leaveReq = LeaveRequest::create($data);
                    if($data['covering_officer_id'] != 0){
                        $this->sendMailToCoveringOfficer($leaveReq['id']);
                    }else{
                        return $this->approvalService->store([
                            'request_id' => $leaveReq->id,
                            'type_id' => 1
                        ]);
                    }
                    return $leaveReq;
                }
                throw new ExceedLeaveLimitException('Leave Limit Exceeded.');
            }
            throw new IllegalArgumentException('Invalid No of days.');
        }
        throw new IllegalArgumentException('Covering officer not available');
    }

    public function checkAvailability(int $empId, int $leaveTypeId, int $year, $noOfDays): bool
    {
        $count = 0;

        $requests = LeaveRequest::where([
            'emp_id' => $empId,
            'leave_type_id' => $leaveTypeId,
            'year' => $year,
        ])->get();

        foreach ($requests as $request) {
            $approval = ForApproval::where([
                'request_id' => $request['id'],
                'request_type_id' => 1,
            ])->orderByDesc('level')->first();
            if($approval){
                if ($approval['is_pending'] == 1 || $approval['is_approved'] == 1) {
                    $count += $request['no_of_days'];
                }
            }

        }

        $special = LeaveBalance::where([
            'emp_id' => $empId,
            'leave_type_id' => $leaveTypeId
        ])->first();

        if ($special) {
            if (($count + $noOfDays) <= $special['count']) {
                return true;
            }
            return false;
        }

        $defaultCount = LeaveType::find($leaveTypeId)->lv_default_count;

        if (($count + $noOfDays) <= $defaultCount) {
            return true;
        }
        return false;
    }

    private function confirmDaysCount(string $from, string $to)
    {
        $response = Http::get('http://localhost:8004/api/calender/getActualWorkingDayCount/' . $from . '/' . $to);
        return $response['data'];
    }

    public function saveAttachments(array $data, int $requestId): void
    {
        foreach ($data as $path) {
            LeaveRequestAttachments::create([
                'request_id' => $requestId,
                'file_path' => $path,
            ]);
        }
    }

    /**
     * @throws ExceedLeaveLimitException
     * @throws UnauthorizedException
     */
    public function update(array $data): void
    {
        $request_id = $data['id'];
        $approval = ForApproval::where([
            'request_id' => $request_id,
            'request_type_id' => 1,
        ])->orderBy('level', 'asc')->first();

        if ($approval['is_pending'] == 0) {
            throw new UnauthorizedException('Can not edit this request anymore.');
        }

        $request = LeaveRequest::find($request_id);

        if (!$this->checkAvailability($request->emp_id, $data['leave_type_id'], $data['year'])) {
            throw new ExceedLeaveLimitException('Leave Limit Exceeded.');
        }

        foreach ($data as $key => $value) {
            if ($request->isFillable($key)) {
                $request->$key = $value;
            }
        }
        $request->save();
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        $requests = LeaveRequest::all(['id', 'request_no', 'emp_id', 'created_at']);
        foreach ($requests as $request) {
            $emp_name = PersonalDetails::find($request['emp_id'])['full_name'];

            $request['employee_name'] = $emp_name;
        }
        return $requests;
    }

    public function getById(int $id)
    {
        return LeaveRequest::find($id);
    }
    private function isCoveringOfficerAvailbale($startDate, $endDate, $officerId){
        $requests = LeaveRequest::where([
            'emp_id'=>$officerId,
        ])->get();

        $finalList = [];

        foreach ($requests as $request){
            $rs = ForApproval::where([
                'request_type_id'=>1,
                'request_id'=>$request['id'],
                'is_pending'=>1,
            ])->first();
            if($rs){
                $finalList[] = $request;
            }
        }

        $isAvailable = true;

        foreach ($finalList as $each){
            foreach ($this->getDuration($each['date_from'], $each['date_to']) as $reqDate){
                foreach ($this->getDuration($startDate, $endDate) as $selfReq){
                    if($selfReq == $reqDate){
                        $isAvailable = false;
                    }
                }
            }

        }
        return $isAvailable;

    }
    private function getDuration($from, $to): array
    {
        $fromDate = new \DateTime($from);
        $toDate = new \DateTime($to);
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($fromDate, $interval, $toDate);
        $dates = [];
        foreach ($period as $date) {
            $formattedDate = $date->format("Y-m-d");
            $dates[] = $formattedDate;
        }
        return $dates;
    }
    private function sendMailToCoveringOfficer($requestId)
    {
        $data = $this->getById($requestId);
        $employee = PersonalDetails::find($data['emp_id']);
        $coveringOfficer = PersonalDetails::find($data['covering_officer_id']);
        $leaveDetails = LeaveType::find($data['leave_type_id']);
        $leaveData = [
            'leave_id'          => $requestId,
            'employee_name'     => $employee['full_name'],
            'covering_officer'  => $coveringOfficer['full_name'],
            'email'             => $coveringOfficer['personal_email'],
            'subject'           => 'Assigned as Leave Covering Officer',
            'message'           => "You have been assigned as the covering officer for {$employee['full_name']} during their leave.",
            'leave_type'        => $leaveDetails['lv_name'],
            'start_date'        => $data['date_from'],
            'end_date'          => $data['date_to'],
            'covering_officer_id' => $coveringOfficer['id'],
            'to' => $coveringOfficer['personal_email'],
        ];
        $this->notificationService->sendMail($leaveData,'leave-request-confirm','Request to become a covering officer');
    }
    private function genarateLeaveRequestNumber(){
        $max = LeaveRequest::max('id');
        return 'REQ/LEV/'.(++$max);
    }
    public function getRemainingLeaveCount($empId, $leaveTypeId){

    }
}
