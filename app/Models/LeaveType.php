<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $table = 'hr_mst_leave_type';
    protected $fillable = [
        'lv_code',
        'lv_name',
        'lv_salary_deduct',
        'lv_count_working_days',
        'lv_default_count',
        'lv_has_limit',
        'lv_allow_attendance_bonus',
        'lv_remarks',
        'lv_status',
        ];
}
