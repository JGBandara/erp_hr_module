<?php

namespace App\Services;

use App\Exceptions\ExceedLeaveLimitException;
use App\Exceptions\IllegalArgumentException;
use App\Exceptions\UnauthorizedException;
use App\Models\ForApproval;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestAttachments;
use App\Models\LeaveType;
use App\Models\PersonalDetails;
use Illuminate\Support\Facades\Http;

class LeaveRequestService
{
    private ApprovalService $approvalService;

    public function __construct(ApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }

    public function store(array $data)
    {
        if ($this->confirmDaysCount($data['date_from'], $data['date_to']) == $data['no_of_days']) {
            if ($this->checkAvailability($data['emp_id'], $data['leave_type_id'], $data['year'], $data['no_of_days'])) {
                $data['covering_officer_id'] = 1;
                $leaveReq = LeaveRequest::create($data);
                $this->approvalService->store([
                    'request_id' => $leaveReq->id,
                    'type_id' => 1
                ]);
                return $leaveReq;
            }
            throw new ExceedLeaveLimitException('Leave Limit Exceeded.');
        }
        throw new IllegalArgumentException('Invalid No of days.');
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
            if ($approval['is_pending'] == 1 || $approval['is_approved'] == 1) {
                $count += $request['no_of_days'];
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

    public function saveAttachments(array $data, int $requestId)
    {
        foreach ($data as $path) {
            LeaveRequestAttachments::create([
                'request_id' => $requestId,
                'file_path' => $path,
            ]);
        }
    }

    public function update(array $data)
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

    public function getAll()
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
}
