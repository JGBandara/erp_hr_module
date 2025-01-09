<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDetails extends Model
{
    use HasFactory;

    protected $table = 'hr_emp_personal_details';
    protected $fillable = [
        'personal_file_no',
        'serial_no',
        'title',
        'initials',
        'surname',
        'full_name',
        'nic',
        'dob',
        'civil_status',
        'gender',
        'religion',
        'permanent_address',
        'mobile',
        'personal_email',
        'current_address',
        'residence_phone_number',
        'emerg_phone_and_cont_num',
    ];

    public function history()
    {
        return $this->hasMany(EmployeeHistory::class, 'emp_id', 'id');
    }

    public function lastDesignation()
    {
        return $this->history()->latest('date_time')->firstOr(function(){
            return null;
        });
    }

    public function olResults()
    {
        return $this->hasMany(OLExamination::class, 'emp_id', 'id');
    }

    public function alResults()
    {
        return $this->hasMany(ALExamination::class, 'emp_id', 'id');
    }

    public function professionalQualifications()
    {
        return $this->hasMany(ProfessionalQualification::class, 'emp_id', 'id');
    }

    public function dependents()
    {
        return $this->hasMany(Dependent::class, 'emp_id', 'id');
    }

    public function profilePic()
    {
        return $this->hasOne(ProfilePic::class, 'emp_id', 'id')->withDefault([
            'url' => null
        ]);
    }

    public function coveringOfficers()
    {
        return $this->hasMany(CoveringOfficer::class, 'emp_id', 'id')->where('is_deleted', '=', 0);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class, 'emp_id', 'id');
    }

    public function approvalOfficer()
    {
        return $this->hasMany(LeaveApprovalOfficer::class, 'emp_id', 'id');
    }

    public function approvalOfficersByLevel(int $level)
    {
        return $this->hasMany(LeaveApprovalOfficer::class, 'emp_id', 'id')
            ->where('level', $level)
            ->where('status', 1)
            ->select(['id', 'emp_id', 'officer_id', 'level'])
            ->get();
    }

    public function assignedEmployees(){
        return $this->hasMany(LeaveApprovalOfficer::class,'officer_id','id');
    }

    public function getAssignedApprovals()
    {
        return $this->hasMany(ForApproval::class, 'action_by', 'id')->where('is_pending', true)->where();
    }
    public function getApprovedRequests(){
        return $this->hasMany(ForApproval::class, 'action_by', 'id')->where('is_pending', true)->where();
    }
    public function notifications(){
        return $this->hasMany(Notification::class,'emp_id','id');
    }
    public function leaveRequests(){
        return $this->hasMany(LeaveRequest::class,'emp_id','id');
    }
    public function leaveBalance(){
        return $this->hasMany(LeaveBalance::class,'emp_id','id');
    }
}
