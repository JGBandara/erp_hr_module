<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApprovalOfficer extends Model
{
    use HasFactory;
    protected $table = 'hr_leave_approval_offices';
    protected $fillable = [
        'emp_id',
        'officer_id',
        'level',
        'status',
        'created_by',
        'modified_by',
        'location_id',
    ];
    public function employee(){
        return $this->belongsTo(PersonalDetails::class,'emp_id','id');
    }
    public function officer()
    {
        return $this->belongsTo(Employee::class, 'officer_id', 'id');
    }
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'emp_id', 'emp_id');
    }
}
