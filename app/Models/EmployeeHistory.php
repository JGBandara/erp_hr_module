<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHistory extends Model
{
    use HasFactory;
    protected $table = 'hr_emp_history';
    protected $fillable = [
        'emp_id',
        'type_id',
        'date_time',
        'department_id',
        'division',
        'designation_id',
        'grade',
        'workstation_id',
    ];
}
