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
}
