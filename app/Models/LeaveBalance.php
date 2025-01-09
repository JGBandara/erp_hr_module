<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_leave_balance';
    protected $fillable = [
        'emp_id',
        'leave_type_id',
        'count',
        'location_id',
        'created_by',
        'modified_by',
        'is_deleted',
        'deleted_by',
    ];
}
