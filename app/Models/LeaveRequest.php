<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $table = 'hrm_leave_request';
    protected $fillable = [
        'request_no',
        'year',
        'emp_id',
        'leave_type_id',
        'date_from',
        'date_to',
        'no_of_days',
        'purpose',
        'remark',
        'location_id',
        'covering_officer_id',
        'created_by',
        'is_deleted',
        'deleted_by',
        'last_modified_by',
    ];
    public function attachments(){
        return $this->hasMany(LeaveRequestAttachments::class,'request_id','id');
    }
    public function employee()
    {
        return $this->belongsTo(PersonalDetails::class, 'emp_id', 'id');
    }
    public function approvals()
    {
        return $this->hasMany(ForApproval::class, 'request_id', 'id')
            ->where('is_pending', true);
    }
    public function approvalOffices()
    {
        return $this->hasMany(LeaveApprovalOfficer::class, 'emp_id', 'emp_id');
    }
}
