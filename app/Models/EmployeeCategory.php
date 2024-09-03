<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCategory extends Model
{
    use HasFactory;
    protected $table = 'hr_mst_emp_category';
    protected $fillable = ['emp_code', 'emp_name', 'emp_level','emp_rank','emp_remark', 'emp_status'];
  
}
